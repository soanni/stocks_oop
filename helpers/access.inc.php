<?php
function isUserLoggedIn(){
	if(isset($_POST['action']) and $_POST['action'] == 'login'){
		if((!isset($_POST['email']) or $_POST['email'] == '') or  (!isset($_POST['password']) or $_POST['password'] == '')){
			$GLOBALS['loginError'] = 'Please fill in both fields';
			return FALSE;
		}
		$password = md5($_POST['password']);
		if(databaseContainsUser($_POST['email'],$password)){
			session_start();
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['password'] = $password;	
			return TRUE;
		}
		else{
			session_start();
			unset($_SESSION['loggedIn']);
			unset($_SESSION['email']);
			unset($_SESSION['password']);
			$GLOBALS['loginError'] = 'The specified email or password are incorrect';
			return FALSE;
		}
	}
	if(isset($_POST['action']) and $_POST['action'] == 'logout'){
			session_start();
			unset($_SESSION['loggedIn']);
			unset($_SESSION['email']);
			unset($_SESSION['password']);
			header('Location: ' . $_POST['goto']);
			exit();
	}
	
	session_start();
	if (isset($_SESSION['loggedIn'])){
		return databaseContainsUser($_SESSION['email'],$_SESSION['password']);
	}
	
}

function databaseContainsUser($email,$pass){
	include 'db_new.inc.php';
	
	try{
		$sql = 'SELECT COUNT(*) FROM users WHERE email = :email AND pass = :pass';
		$s = $pdo->prepare($sql);
		//$s->bindValue(':email',$email);
		//$s->bindValue(':pass',$pass);
		$s->execute(array('email'=>$email,'pass'=>$pass));
	}
	catch(PDOException $e){
		$error = 'Error fetching companies.';
		include 'error.html.php';
		exit();
	}
	
	$row = $s->fetch();
	if($row[0] > 0){
		return TRUE;
	}
	else{
		return FALSE;
	}
}

function userHasRole($roleid){
	include 'db_new.inc.php';
			
	try{
		$sql = 'SELECT COUNT(*)
				FROM userrole ur
				INNER JOIN users u ON ur.userid = u.userid
				WHERE ur.roleid = :roleid AND u.email = :email';
		$s = $pdo->prepare($sql);
		//$s->bindValue(':email',$_SESSION['email']);
		//$s->bindValue(':roleid',$roleid);
		$s->execute(array('roleid'=>$roleid,'email'=>$_SESSION['email']));
	}
	catch(PDOException $e){
		$error = 'Error searching for user roles.';
		include 'error.html.php';
		exit();
	}
	
	$row = $s->fetch();
	if($row[0] > 0){
		return TRUE;
	}
	else{
		return FALSE;
	}
	
}