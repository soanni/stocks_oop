<?php
	include '../helpers/db_new.inc.php';
	/////////////// AJAX
	if(isset($_POST['quoteid'])){
		try{
			$sql = 'SELECT c.companyname,cc.countryname,IFNULL(obj.attrvalueid,"0001")	as step
					FROM quotes q
					INNER JOIN companies c ON c.companyid = q.companyid
					INNER JOIN countries cc ON c.countryid = cc.countryid
					LEFT JOIN objectsattributes obj on obj.id = q.qid and obj.objtype=2 and obj.attrid=1 and obj.ActiveFlag = 1
					WHERE q.ActiveFlag = 1 and q.qid = :quoteid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':quoteid', $_POST['quoteid']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error fetching AJAX request: ' . $e->getMessage();
			include 'error.html.php';
			exit();
		}

		foreach ($s as $row)
		{
			$result[] = array('countryname' => $row['countryname']
							  ,'companyname' => $row['companyname']
							  ,'step' => $row['step']);
		}
		
		echo json_encode($result);	
	}