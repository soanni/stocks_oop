<?php
    require_once '../helpers/autoload.inc.php';
    require_once '../helpers/db_new.inc.php';
    require_once '../helpers/magicquotes.inc.php';

	
	if(isset($_POST['action']) and $_POST['action'] == 'Delete'){

		try{
			$sql = 'SELECT qid FROM quotes WHERE exchid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id',$_POST['id']);
			$s->execute();
		}
		catch(PDOException $e){
			$error = 'Error fetching quotes: ' . $e->getMessage();
			include '../helpers/error.html.php';
			exit();
		}
		$result = $s->fetchAll();
		
		// DELETE rates ///////////////////////////
		try{
			$sql = 'DELETE FROM rates WHERE quoteid = :qid';
			$s = $pdo->prepare($sql);
			foreach($result as $row){
				$s->bindValue(':qid',$row['qid']);
				$s->execute();
			}
        }			
		catch(PDOException $e){
			$error = 'Error deleting rates: ' . $e->getMessage();
			include '../helpers/error.html.php';
			exit();
		}
		
		// DELETE quotes ///////////////////////////
		try{
			$sql = 'DELETE FROM quotes WHERE exchid = :exchid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':exchid',$_POST['id']);
			$s->execute();
        }			
		catch(PDOException $e){
			$error = 'Error deleting quotes: ' . $e->getMessage();
			include '../helpers/error.html.php';
			exit();
		}
		
		// DELETE exchanges //////////////////////////////////////
		
		try{
			$sql = 'DELETE FROM exchanges WHERE exchid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id',$_POST['id']);
			$s->execute();
        }			
		catch(PDOException $e){
			$error = 'Error deleting exchanges: ' . $e->getMessage();
			include '../helpers/error.html.php';
			exit();
		}
		
		header('Location: .');
		exit();
		
	}
	
	// ADD AND EDIT EXCHANGES
	
	// ADD
	if (isset($_GET['addexchange'])){
		$pageTitle = 'New Exchange';
		$action = 'addform';
		$name = '';
		$web = '';
		$id = '';
		$button = 'Add exchange';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['addform'])){
        Exchange::insertExchange($_POST['name'],$_POST['web']);
		header('Location: .');
		exit();
	}
	
	//EDIT
	if (isset($_POST['action']) and $_POST['action'] == 'Edit'){
        $arr = Exchange::getExchanges($_POST['id']);
        $row = $arr[0];
		$pageTitle = 'Edit Exchange';
		$action = 'editform';
		$name = $row->_name;
		$web = $row->_web;
		$id = $row->_id;
		$button = 'Update exchange';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['editform'])){
        Exchange::updateExchange($_POST['id'],$_POST['name'],$_POST['web']);
		header('Location: .');
		exit();
	}
	
	// SELECT THE LIST OF EXCHANGES //////////////////////////////////////////////////////  

    $exchanges = Exchange::getExchanges();
	include 'exchanges.html.php';