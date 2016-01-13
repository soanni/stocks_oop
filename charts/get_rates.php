<?php
	include '../helpers/db_new.inc.php';
	/////////////// AJAX
	if(isset($_POST['companyid']) and isset($_POST['startdate']) and isset($_POST['enddate'])){
    try{
        $sql = 'SELECT DISTINCT r.openrate
						   ,r.lastdeal as closerate
						   ,r.minimum
						   ,r.maximum
						   ,r.ratedate
					FROM rates r
					LEFT JOIN quotes q on r.quoteid = q.qid
					WHERE q.qid = :quoteid
						  and r.ratedate between :start and :end
						  and r.ActiveFlag = 1
					ORDER BY r.ratedate asc';
        $s = $pdo->prepare($sql);
        $s->bindValue(':quoteid', $_POST['companyid']);
        $s->bindValue(':start', $_POST['startdate']);
        $s->bindValue(':end', $_POST['enddate']);
        $s->execute();
    }
    catch (PDOException $e){
        $error = 'Error fetching rates via Ajax: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row)
    {
        $result[] = array('ratedate' => $row['ratedate']
        ,'maximum' => $row['maximum']
        ,'minimum' => $row['minimum']
        ,'openrate' => $row['openrate']
        ,'closerate' => $row['closerate']);
    }

    echo json_encode($result);
}