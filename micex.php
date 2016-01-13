<?php
	//include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	include 'helpers/db_new.inc.php';
	
	try{
        // запрос изменения в процентах по цене закрытия
/*		$sql = 'SELECT (trim(r.closerate)+0) as closerate
					   ,r.minimum
					   ,r.maximum
					   ,r.ratedate
					   ,q.acronym
					   ,q.fullname
					   ,round((r.closerate/inn2.closerate - 1)*100,2) as percent
				FROM rates r
				INNER JOIN (select quoteid, max(ratedate) as date from rates where activeflag=1 group by quoteid) inn ON inn.quoteid = r.quoteid and inn.date = r.ratedate
				LEFT JOIN (select rr.quoteid, rr.ratedate, rr.closerate
							from rates rr
							inner join (select distinct ratedate day from rates rrr order by ratedate desc limit 1,1) i on rr.ratedate = i.day) inn2 ON r.quoteid = inn2.quoteid
				LEFT JOIN quotes q on r.quoteid = q.qid
				INNER JOIN indiceslinks l on l.quoteid = q.qid
				WHERE r.ActiveFlag = 1 and l.indid = :ind
				ORDER BY percent desc';*/
        // запрос изменения в процентах по цене последней сделки
        $sql = 'SELECT (trim(r.lastdeal)+0) as closerate
					   ,r.minimum
					   ,r.maximum
					   ,r.ratedate
					   ,q.acronym
					   ,q.fullname
					   ,round((r.lastdeal/inn2.lastdeal - 1)*100,2) as percent
				FROM rates r
				INNER JOIN (select quoteid, max(ratedate) as date from rates where activeflag=1 group by quoteid) inn ON inn.quoteid = r.quoteid and inn.date = r.ratedate
				LEFT JOIN (select rr.quoteid, rr.ratedate, rr.lastdeal
							from rates rr
							inner join (select distinct ratedate day from rates rrr order by ratedate desc limit 1,1) i on rr.ratedate = i.day) inn2 ON r.quoteid = inn2.quoteid
				LEFT JOIN quotes q on r.quoteid = q.qid
				INNER JOIN indiceslinks l on l.quoteid = q.qid
				WHERE r.ActiveFlag = 1 and l.indid = :ind
				ORDER BY percent desc';
		$s = $pdo->prepare($sql);
        $s->bindValue(':ind',$_GET['ind']);
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
						  ,'closerate' => $row['closerate']
						  ,'acronym' => $row['acronym']
						  ,'fullname' => $row['fullname']
						  ,'percent' => $row['percent']);
	}
	
	include 'tab.php';
		