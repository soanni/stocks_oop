<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
	// GET INDICES LIST
    try{
        $sql = 'SELECT
                    indname as name
                    ,indexid  as id
                FROM indices
                WHERE ActiveFlag=1';
        $result = $pdo->query($sql);
    }
    catch (PDOException $e){
        $error = 'Error fetching indices: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    foreach($result as $row){
        $indices[] = array('name' => $row['name']
                            ,'id' => $row['id']
                            ,'selected' => FALSE);
    }

	// GET COUNTRIES LIST ///////////////////////
	try{
		$sql = 'SELECT 
					countryname as name
					,countryid  as id 
				FROM countries';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching countries: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$countries[] = array('name' => $row['name']
							,'id' => $row['id']
							,'selected' => TRUE);
	}
	
	// GET COMPANIES LIST ///////////////////
	try{
		$sql = 'SELECT 
					companyname as name
					,companyid  as id 
				FROM companies
				WHERE ActiveFlag = 1';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching companies: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$companies[] = array('name' => $row['name']
							,'id' => $row['id']
							,'selected' => TRUE);
	}
	
	// GET EXCHANGES LIST ///////////////////
	try{
		$sql = 'SELECT 
					exchname as name
					,exchid  as id 
				FROM exchanges';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching exchanges: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$exchanges[] = array('name' => $row['name']
							,'id' => $row['id']
							,'selected' => TRUE);
	}
	
	// ACTIONS
	
	// ADD
	if (isset($_GET['addshare'])){
		$pageTitle = 'New Share';
		$action = 'addform';
		$sharename = '';
		$shortname = '';
		$englishname = '';
		$acronym = '';
		$exchangeid = '';
		$countryid = '';
		$companyid = '';
		$id = '';
		$privileged = '';
		$button = 'Add share';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['addform'])){	
		if($_POST['sharename'] == '' or $_POST['exchange'] == ''
			or $_POST['shortname'] == ''
            //or $_POST['englishname'] == ''
			or $_POST['country'] == '' or $_POST['company'] == ''){
			$error = 'You must fill in all fields to complete.';
			include 'error.html.php';
			exit();
		}
				
		try{
			$sql = 'INSERT INTO quotes SET 
					activeflag = 1
					,changedate = CURDATE()
					,fullname = :fullname
					,shortname = :shortname
					,englishname = :englishname
					,acronym = :acronym
					,companyid = :companyid
					,exchid = :exchangeid
					,privileged = :privileged';
			$s = $pdo->prepare($sql);
			$s->bindValue(':fullname', $_POST['sharename']);
			$s->bindValue(':shortname', $_POST['shortname']);
			$s->bindValue(':englishname', $_POST['englishname']);
			$s->bindValue(':acronym', $_POST['acronym']);
			$s->bindValue(':companyid', $_POST['company']);
			$s->bindValue(':exchangeid', $_POST['exchange']);
			$s->bindValue(':privileged', $_POST['privileged']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error adding submitted share.' . $e->getMessage();
			include 'error.html.php';
			exit();
		}
		header('Location: .');
		exit();
	}
	
	//EDIT
	
	 if(isset($_POST['action']) and $_POST['action'] == 'Edit'){
		 try{
			 $sql = 'SELECT
                        q.qid
                        ,q.fullname
                        ,q.shortname
                        ,q.englishname
                        ,q.acronym
                        ,q.privileged
                        ,q.exchid
                        ,q.companyid
                        ,c.countryid
                        ,c.companyname
                        ,e.exchname
                        ,cc.countryname
                     FROM quotes q
                     INNER JOIN companies c ON q.companyid = c.companyid
                     INNER JOIN exchanges e ON q.exchid = e.exchid
                     INNER JOIN countries cc ON c.countryid = cc.countryid
                     WHERE q.qid = :qid';
			 $s = $pdo->prepare($sql);
			 $s->bindValue(':qid', $_POST['id']);
			 $s->execute();
		 }
		 catch(PDOException $e){
			 $error = 'Error fetching share details.';
			 include 'error.html.php';
			 exit();
		 }

		 $row = $s->fetch();
		 $pageTitle = 'Edit Share';
		 $action = 'editform';
         $sharename = $row['fullname'];
         $shortname = $row['shortname'];
         $englishname = $row['englishname'];
         $acronym = $row['acronym'];
         $exchangeid = $row['exchid'];
		 $companyid = $row['companyid'];
         $countryid = $row['countryid'];
         $privileged = $row['privileged'] ;
         $id = $row['qid'];
		 $button = 'Edit share';

         try{
             $sql = 'SELECT
                    indname as name
                    ,indexid  as id
                    ,CASE
                        WHEN l.quoteid IS NULL THEN FALSE
                        ELSE TRUE
                    END as selected
                FROM indices i
                LEFT JOIN indiceslinks l ON i.indexid = l.indid  and l.quoteid = :qid
                WHERE i.ActiveFlag=1';
             $s = $pdo->prepare($sql);
             $s->bindValue(':qid', $_POST['id']);
             $s->execute();

         }
         catch(PDOException $e){
             $error = 'Error fetching indices details for quote.';
             include 'error.html.php';
             exit();
         }
         unset($indices);
         while($r = $s->fetch()){
             $indices[] = array('name' => $r['name']
                                 ,'id' => $r['id']
                                 ,'selected' => $r['selected']);
         }
		 include 'form.html.php';
		 exit();
	 }
	
	 if(isset($_GET['editform'])){
		 try{
			 $sql = 'UPDATE quotes
                    SET
                        fullname = :fullname
                        ,shortname = :shortname
                        ,englishname = :english
                        ,acronym = :acronym
                        ,privileged = :priv
                        ,exchid = :exchid
                        ,companyid = :companyid
                        ,ChangeDate = NOW()
                    WHERE qid = :id';
			 $s = $pdo->prepare($sql);
             $s->bindValue(':fullname', $_POST['sharename']);
             $s->bindValue(':shortname', $_POST['shortname']);
             $s->bindValue(':english', $_POST['englishname']);
             $s->bindValue(':acronym', $_POST['acronym']);
             $s->bindValue(':companyid', $_POST['company']);
             $s->bindValue(':exchid', $_POST['exchange']);
             $s->bindValue(':priv', $_POST['privileged']);
             $s->bindValue(':id',$_POST['id']);
			 $s->execute();
		 }
		 catch(PDOException $e){
			 $error = 'Error updating share.';
			 include 'error.html.php';
			 exit();
		 }
         try {
             $sql = 'DELETE FROM indiceslinks where quoteid = :qid';
             $s = $pdo->prepare($sql);
             $s->bindValue(':qid',$_POST['id']);
             $s->execute();
             if(isset($_POST['indices'])){
                 foreach($_POST['indices'] as $index){
                     $sql = 'INSERT INTO indiceslinks
                              SET
                                  indid = :indid
                                  ,quoteid = :qid
                                  ,started = NOW()
                                  ,finished = NOW()
                                  ,ActiveFlag = 1
                                  ,ChangeDate = NOW()';
                     $s = $pdo->prepare($sql);
                     $s->bindValue(':qid',$_POST['id']);
                     $s->bindValue(':indid', $index);
                     $s->execute();
                 }
             }
         }
         catch(PDOException $e){
             $error = 'Error updating table indiceslinks.';
             include 'error.html.php';
             exit();
         }
		 header('Location: .');
		 exit();
	 }
	
	//DELETE
	
	// if(isset($_POST['action']) and $_POST['action'] == 'Delete'){
		// try{
			// $sql = 'UPDATE companies SET ActiveFlag=0 WHERE companyid = :id';
			// $s = $pdo->prepare($sql);
			// $s->bindValue(':id', $_POST['id']);
			// $s->execute();
		// }
		// catch(PDOException $e){
			// $error = 'Error updating company.';
			// include 'error.html.php';
			// exit();	
		// }
		// header('Location: .');
		// exit();
	// }

	///////////////SELECT THE LIST OF SHARES //////////////////////////////////////////////////////  	
	
	try{
		$sql = 'SELECT q.qid
					,q.fullname
					,q.acronym
					,e.exchname as exchange
					,c.companyname as company
					,cc.countryname as country	
					,q.privileged
					,q.ActiveFlag as active
		        FROM quotes q
				INNER JOIN companies c ON q.companyid = c.companyid
				INNER JOIN countries cc ON c.countryid = cc.countryid
				INNER JOIN exchanges e ON e.exchid = q.exchid';				
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching shares: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		try{
			$sql = 'SELECT indname
					FROM indiceslinks l
					INNER JOIN indices i ON l.indid = i.indexid
					WHERE l.ActiveFlag = 1 and l.quoteid = :qid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':qid', $row['qid']);
			$s->execute();
            $str = '';
            while($r = $s->fetch()){
                $str = $str.' '.$r['indname'];
            }
			//$result = $s->fetchAll();
           // $str = '';
           // if(sizeof($result)>0){
           //     $str = array_reduce($result[0], 'indicesToString','');
           // }
			
			$shares[] = array('qid' => $row['qid']
							,'fullname' => $row['fullname']
							,'acronym' => $row['acronym']
							,'exchange'=>$row['exchange']
							,'company'=>$row['company']
							,'country'=>$row['country']
							,'privileged'=>$row['privileged']
							,'active'=>$row['active']
							//,'indices'=>$result[0][0]);
							,'indices' => $str);
		}
		catch(PDOException $e){
			$error = 'Error fetching indices: ' . $e->getMessage();
			include 'error.html.php';
			exit();	
		}

	}
	include 'quotes.html.php';