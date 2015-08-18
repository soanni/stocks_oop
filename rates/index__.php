<?php
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

//    if(!isUserLoggedIn()) {
//        include '../login.html.php';
//        exit();
//    }

// ACTIONS

// IMPORT FROM CSV
if(isset($_GET['files'])){
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

///////////////////////////////////////////////
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