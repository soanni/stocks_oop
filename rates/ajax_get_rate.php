<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	
	if(isset($_POST['qid']) and isset($_POST['ratedate'])){
		try{
			$sql = 'SELECT closerate			
			FROM rates
			WHERE ActiveFlag = 1 
				and quoteid = :quoteid 
				and ratedate = :ratedate';
			$s = $pdo->prepare($sql);
			$s->bindValue(':quoteid', $_POST['qid']);
			$s->bindValue(':ratedate', $_POST['ratedate']);
			$s->execute();	
		}
		catch (PDOException $e){
			$error = 'Error fetching AJAX request: ' . $e->getMessage();
			include 'error.html.php';
			exit();
		}
		$result = 0;
		foreach ($s as $row)
		{
			$result = $row['closerate'];
		}
		
		echo json_encode($result);	
	}