<?php
	include '../helpers/db_new.inc.php';
	
	// GET COMPANIES LIST ///////////////////
	try{
		$sql = 'SELECT 
					shortname as name
					,qid  as id
				FROM quotes
				WHERE ActiveFlag = 1';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching quotes: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$companies[] = array('name' => $row['name']
							,'id' => $row['id']
							,'selected' => TRUE);
	}
	//SEARCH
	include 'searchform.html.php';
	