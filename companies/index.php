<?php
	include '../helpers/db_new.inc.php';
	// include $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';
	
	// if(!isUserLoggedIn()){
		// include '../login.html.php';
		// exit();
	// }
	
	// if(!userHasRole('2') or !userHasRole('1')){
		// $error = '';
		// include '../accessdenied.html.php';
		// exit();
	// }
	
	// SELECT LIST OF COUNTRIES
	
	try{
		$sql = 'SELECT countryname,countryid FROM countries';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching countries: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$countries[] = array('name' => $row['countryname']
							,'id' => $row['countryid']
							,'selected' => TRUE);
	}
	
	// ACTIONS
	
	// ADD
	if (isset($_GET['addcompany'])){
		$pageTitle = 'New Company';
		$action = 'addform';
		$companyname = '';
		$web = '';
		$id = '';
		$countryid = 0;
		$button = 'Add company';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['addform'])){
		//include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
		
		if($_POST['countryname'] == ''){
			$error = 'You must choose a country for this company.Click &lsquo;back&rsquo; and try again.';
			include 'error.html.php';
			exit();
		}		
		try{
			$sql = 'INSERT INTO companies SET activeflag = 1, changedate = CURDATE(),companyname = :name, web = :web, countryid = :countryid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['companyname']);
			$s->bindValue(':web', $_POST['web']);
			$s->bindValue(':countryid', $_POST['countryname']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error adding submitted company.';
			include 'error.html.php';
			exit();
		}
		header('Location: .');
		exit();
	}
	
	//EDIT
	
	if(isset($_POST['action']) and $_POST['action'] == 'Edit'){
		try{
			$sql = 'SELECT * FROM companies WHERE companyid = :companyid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':companyid', $_POST['id']);
			$s->execute();
		}
		catch(PDOException $e){
			$error = 'Error fetching company details.';
			include 'error.html.php';
			exit();		
		}
		$row = $s->fetch();
		$pageTitle = 'Edit Company';
		$action = 'editform';
		$companyname = $row['companyname'];
		$web = $row['web'];
		$id = $row['companyid'];
		$countryid = $row['countryid'];
		$button = 'Edit company';
		include 'form.html.php';
		exit();
	}
	
	if(isset($_GET['editform'])){
		try{
			$sql = 'UPDATE companies SET companyname = :name, web = :web, countryid = :countryid, ChangeDate = CURDATE() WHERE companyid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->bindValue(':name', $_POST['companyname']);
			$s->bindValue(':web', $_POST['web']);
			$s->bindValue(':countryid', $_POST['countryname']);
			$s->execute();
		}
		catch(PDOException $e){
			$error = 'Error updating company.';
			include 'error.html.php';
			exit();	
		}
		header('Location: .');
		exit();
	}
	
	//DELETE
	
	if(isset($_POST['action']) and $_POST['action'] == 'Delete'){
		try{
			$sql = 'UPDATE companies SET ActiveFlag=0 WHERE companyid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->execute();
		}
		catch(PDOException $e){
			$error = 'Error updating company.';
			include 'error.html.php';
			exit();	
		}
		header('Location: .');
		exit();
	}
		
	//SEARCH
	include 'searchform.html.php';
	
	if(isset($_GET['action']) and $_GET['action'] == 'Search'){
		$select =   'SELECT cc.countryname as country
					   ,c.web
					   ,c.companyid
					   ,c.companyname
					   ,c.ActiveFlag
					FROM companies c
					INNER JOIN countries cc ON cc.countryid = c.countryid';
		$where = ' WHERE TRUE';
		if(isset($_GET['activeflag']) and $_GET['activeflag'] == 1){
			$where .= ' AND c.ActiveFlag = 1';
		}
		if($_GET['countries'] != ''){
			$where .= ' AND cc.countryid IN ';
		}
		try{
			$sql = $select . $where;
			$arr = '(0';
			foreach($_GET['countries'] as $element){
				$arr .= ',';
				$arr .= $element;
			}
			$arr .= ')';
			$sql .= $arr;
			$s = $pdo->prepare($sql);
			$s->execute();
		}
		catch(PDOException $e){
			$error = 'Error fetching companies.';
			include 'error.html.php';
			exit();
		}
		
		foreach ($s as $row)
		{
			$companies[] = array('country' => $row['country']
								,'web' => $row['web']
								,'companyid' => $row['companyid']
								,'companyname'=>$row['companyname']
								,'active'=>$row['ActiveFlag']);
		}
		
		include 'companies.html.php';
		exit();
	}
	
	///////////////////
	
	
		
	// SELECT THE LIST OF COMPANIES //////////////////////////////////////////////////////  
	
	//include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	
	// try{
		// $sql = 'SELECT cc.countryname as country
					   // ,c.web
					   // ,c.companyid
					   // ,c.companyname
		        // FROM companies c
				// INNER JOIN countries cc ON cc.countryid = c.countryid';
		// $result = $pdo->query($sql);
	// }
	// catch (PDOException $e){
		// $error = 'Error fetching companies: ' . $e->getMessage();
		// include 'error.html.php';
		// exit();
	// }
	// foreach($result as $row){
		// $companies[] = array('country' => $row['country']
							// ,'web' => $row['web']
							// ,'companyid' => $row['companyid']
							// ,'companyname'=>$row['companyname']);
	// }
	// include 'companies.html.php';
	
	
	// try{
		// $sql = 'SELECT countryid,countryname FROM countries';
		// $result = $pdo->query($sql);
	// }
	// catch (PDOException $e){
		// $error = 'Error fetching countries: ' . $e->getMessage();
		// include 'error.html.php';
		// exit();
	// }
	// foreach($result as $row){
		// $countries[] = array('country' => $row['countryname']
							// ,'countryid' => $row['countryid']);
	// }
	
	