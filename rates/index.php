<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

//    if(!isUserLoggedIn()) {
//        include '../login.html.php';
//        exit();
//    }
	
	// SELECT LIST OF QUOTES //////////////////////////////////////////////////////////
	
	try{
		$sql = 'SELECT 
					q.qid
					,q.fullname
					,q.acronym
					,q.companyid
					,c.companyname
					,cc.countryid
					,cc.countryname					
				FROM quotes q
				INNER JOIN companies c ON c.companyid = q.companyid
				INNER JOIN countries cc ON c.countryid = cc.countryid
				WHERE q.ActiveFlag = 1';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching quotes: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$quotes[] = array('qid' => $row['qid']
							,'fullname' => $row['fullname']
							,'acronym' => $row['acronym']
							,'companyid'=>$row['companyid']
							,'companyname'=>$row['companyname']
							,'countryid'=>$row['countryid']
							,'countryname'=>$row['countryname']);
	}	
	// ACTIONS

    // IMPORT FROM CSV
    if(isset($_GET['files'])){
        //include 'import.html.php';
        //$arr = array('@dummy','lastdeal','openrate','maximum','minimum',
        //    'closerate','dayvol','ratedate','@dummy1','quoteid');
        //$arr = array('ratedate','@dummy','openrate','maximum','minimum','closerate','dayvol','quoteid');
        $arr = array('@dummy1','lastdeal','@dummy2','openrate','maximum','minimum','closerate','dayvol','ratedate','@dummy3','quoteid');
        $filename = $_GET['files'][0];
        $q = import_csv('rates',$arr,$filename);
        try{
            $link = mysql_connect('localhost', 'stocksuser', 'jd5xugLMrr') or die('Could not connect to server.' );
            mysql_select_db('stocks_new', $link) or die('Could not select database.');
            mysql_query($q,$link) or die(mysql_error());
            //echo "File was uploaded successfully";
            header('Location: .');
        }
        catch (PDOException $e){
            $error = 'Error loading CSV: ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
    }
	
	// ADD
	if (isset($_GET['addrate'])){
		$pageTitle = 'New Rate';
		$action = 'addform';
		$quoteid = 0;
		$company = '';
		$country = '';
		$openrate = 0;
		$closerate = 0;
		$ratedate = '';
		$dayminimum = 0;
		$daymaximum = 0;
		$step = 1;
		$id = '';
		$button = 'Add rate';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['addform'])){
		
		if($_POST['quote'] == '' or $_POST['openrate'] == '' or $_POST['closerate'] == '' or $_POST['ratedate'] == '' or $_POST['dayminimum'] == '' or $_POST['daymaximum'] == ''){
			$error = 'You must fill in all fields.';
			include 'error.html.php';
			exit();
		}		
		try{
			$sql = 'INSERT INTO rates 
							SET activeflag = 1
								,changedate = CURDATE()
								,quoteid = :qid
								,openrate = :open
								,closerate = :close
								,ratedate = :day
								,minimum = :min
								,maximum = :max';
			$s = $pdo->prepare($sql);
			$s->bindValue(':qid', $_POST['quote']);
			$s->bindValue(':open', $_POST['openrate']);
			$s->bindValue(':close', $_POST['closerate']);
			$s->bindValue(':day', $_POST['ratedate']);
			$s->bindValue(':min', $_POST['dayminimum']);
			$s->bindValue(':max', $_POST['daymaximum']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error adding submitted rate.';
			include 'error.html.php';
			exit();
		}
		header('Location: .');
		exit();
	}
	
	////////////////////////////	EDIT
	
	if(isset($_POST['action']) and $_POST['action'] == 'Edit'){
		try{
			$sql = 'SELECT q.qid
						   ,r.rateid
						   ,r.openrate
						   ,r.closerate
						   ,r.ratedate
						   ,r.minimum
						   ,r.maximum
						   ,c.companyname
						   ,cc.countryname
					FROM rates r
					LEFT JOIN quotes q ON r.quoteid = q.qid
					LEFT JOIN companies c ON q.companyid = c.companyid
					LEFT JOIN countries cc ON c.countryid = cc.countryid
					WHERE rateid = :rateid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':rateid', $_POST['id']);
			$s->execute();
		}
		catch(PDOException $e){
			$error = 'Error fetching rate details.';
			include 'error.html.php';
			exit();		
		}
		$row = $s->fetch();
		$pageTitle = 'Edit Rate';
		$action = 'editform';
		$company = $row['companyname'];
		$country = $row['countryname'];
		$openrate = $row['openrate'];
		$closerate = $row['closerate'];
		$ratedate = $row['ratedate'];
		$dayminimum = $row['minimum'];
		$daymaximum = $row['maximum'];
		$quoteid = $row['qid'];
		$step = 0.01;
		$id = $row['rateid'];
		$button = 'Edit rate';
		include 'form.html.php';
		exit();
	}
	
	if(isset($_GET['editform'])){
		try{
			$sql = 'UPDATE rates SET openrate = :open
									 ,closerate = :close
									 ,ratedate = :date
									 ,minimum = :min
									 ,maximum = :max
									 ,ChangeDate = NOW()
					WHERE rateid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['rateid']);
			$s->bindValue(':open', $_POST['openrate']);
			$s->bindValue(':close', $_POST['closerate']);
			$s->bindValue(':min', $_POST['dayminimum']);
			$s->bindValue(':max', $_POST['daymaximum']);
			$s->bindValue(':date', $_POST['ratedate']);
			$s->execute();
		}
		catch(PDOException $e){
			$error = 'Error updating rate.';
			include 'error.html.php';
			exit();	
		}
		header('Location: .');
		exit();
	}
	
	//DELETE
	
	if(isset($_POST['action']) and $_POST['action'] == 'Delete'){
		try{
			$sql = 'UPDATE rates SET ActiveFlag=0 WHERE rateid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->execute();
		}
		catch(PDOException $e){
			$error = 'Error deleting rate.';
			include 'error.html.php';
			exit();	
		}
		header('Location: .');
		exit();
	}
	
	// SELECT LIST OF RATES //////////////////////////////////////////////////////////
	
	try{
        $sql = 'SELECT * FROM rates_view';
//		$sql = 'SELECT cc.countryname
//					   ,c.companyname
//					   ,c.web
//					   ,q.fullname
//					   ,q.acronym
//					   ,r.rateid
//					   ,trim(r.openrate)+0 as openrate
//					   ,trim(r.closerate)+0 as closerate
//					   ,r.ratedate
//					   ,trim(r.minimum)+0 as dayminimum
//					   ,trim(r.maximum)+0 as daymaximum
//					   ,r.lastdeal
//					   ,r.activeflag as active
//				FROM rates r
//				INNER JOIN quotes q ON r.quoteid = q.qid
//				INNER JOIN companies c ON c.companyid = q.companyid
//				INNER JOIN countries cc ON cc.countryid = c.countryid
//				ORDER BY q.companyid,r.ratedate asc';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching rates: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$rates[] = array('countryname'=>$row['countryname']
							,'companyname'=>$row['companyname']
							,'web'=>$row['web']
							,'fullname'=>$row['fullname']
							,'acronym'=>$row['acronym']
							,'rateid'=>$row['rateid']
							,'openrate'=>$row['openrate']
							,'closerate'=>$row['closerate']
							,'ratedate'=>$row['ratedate']
							,'dayminimum'=>$row['dayminimum']
							,'daymaximum'=>$row['daymaximum']
                            ,'lastdeal'=>$row['lastdeal']
							,'active'=>$row['active']);
	}

    function import_csv(
        $table, 		// Имя таблицы для импорта
        $afields, 		// Массив строк - имен полей таблицы
        $filename, 	 	// Имя CSV файла, откуда берется информация
        // (путь от корня web-сервера)
        $delim = ';',  		// Разделитель полей в CSV файле
        $enclosed = '"',  	// Кавычки для содержимого полей
        $escaped = '\\', 	 	// Ставится перед специальными символами
        $lineend = '\\r\\n',   	// Чем заканчивается строка в файле CSV
        $hasheader = TRUE){  	// Пропускать ли заголовок CSV

        if($hasheader)
            $ignore = "IGNORE 1 LINES ";
        else
            $ignore = "";
        $q_import =
            "LOAD DATA LOCAL INFILE '".
            $_SERVER['DOCUMENT_ROOT'].'/includes/rates_arc/'.$filename."' INTO TABLE ".$table." "
            ."FIELDS TERMINATED BY '".$delim. "'OPTIONALLY ENCLOSED BY '".$enclosed."' "
            //."ESCAPED BY '".$escaped."' "
            ."LINES TERMINATED BY '".$lineend."' "
            .$ignore.
            "(".implode(',', $afields).")"
            ." SET ActiveFlag = 1, ChangeDate = NOW()";
        return $q_import;
    }
	include 'rates.html.php';
	
	///////////////////