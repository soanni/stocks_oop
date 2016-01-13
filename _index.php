	<!DOCTYPE html>
	<html>
		<head>
			<title>Stock Exchanges Management System</title>
			<meta charset="utf-8"/>
			<link href = "css/style.css" rel = "stylesheet" type = "text/css"/>
			<link rel="stylesheet" type="text/css" href="jqChart/css/jquery.jqChart.css"/>
			<link rel="stylesheet" type="text/css" href="jqChart/css/jquery.jqRangeSlider.css"/>
			<link rel="stylesheet" type="text/css" href="jqChart/themes/smoothness/jquery-ui-1.10.4.css"/>
		</head>
		<body>
<!--		
		<section id="navigation">
			<h1>Stock Exchanges Management System</h1>
			<h5 class="divheader">Manage Exchanges</h5>
			<div>
				<img class="frontpage" src = "img/stock_opt.jpg"/>
				<p class="description">Управление списком мировых биржевых площадок.</p>
			</div>
			<h5 class="divheader">Manage Countries</h5>
			<div>
				<img class="frontpage" src = "img/country_opt.jpg"/>
				<p class="description">Управление списком стран.</p>
			</div>
			<h5 class="divheader">Manage Currencies</h5>
			<div>
				<img class="frontpage" src = "img/currency_opt.jpg"/>
				<p class="description">Управление списком валют.</p>
			</div>
			<h5 class="divheader">Manage Companies</h5>
			<div>
				<img class="frontpage" src = "img/company_opt.jpg"/>
				<p class="description">Управление списком компаний.</p>
			</div>
			<h5 class="divheader">Manage Quotes</h5>
			<div>
				<img class="frontpage" src = "img/index_opt.jpg"/>
				<p class="description">Управление списком биржевых индексов.</p>
			</div>
			<h5 class="divheader">Manage Rates</h5>
			<div>
				<img class="frontpage" src = "img/rate_opt.jpg"/>
				<p class="description">Управление котировками.</p>
			</div>
		</section>
-->	
		<!--<h1>Stock Exchanges Management System</h1>-->
		<div id="navigation">
			<ul>
				<li id = "exchange"><a href = "exchanges/">Exchanges</a></li>
				<li id = "country"><a href = "countries/">Countries</a></li>
				<li id = "currency"><a href = "currencies/">Currencies</a></li>
				<li id = "company"><a href = "companies/">Companies</a></li>
				<li id = "quote"><a href = "quotes/">Quotes</a></li>
				<li id = "rate"><a href = "rates/">Rates</a></li>
			</ul>
		</div>
		<div>
			<div id="jqChart" style="width: 1000px; height: 250px;"></div>
		</div>
		<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="js/jquery.color-2.1.2.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
		<script type="text/javascript" src="jqChart/js/jquery.jqChart.min.js"></script>
		<script type="text/javascript" src="jqChart/js/jquery.jqRangeSlider.min.js"></script>
		<script type="text/javascript" src="js/common.js"></script>
		<script type="text/javascript" src="js/chart.js"></script>
		</body>
	</html>
	
<?php
	// include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	// header('Content-type: text/html; charset=utf-8');
	// if(!setlocale(LC_ALL, 'ru_RU.utf8')) 
		// setlocale(LC_ALL, 'en_US.utf8');
	// if(setlocale(LC_ALL, 0) == 'C') 
		// die('Не поддерживается ни одна из перечисленных локалей (ru_RU.utf8, en_US.utf8)');
	// $handle = fopen('php://memory', 'w+');
	// fwrite($handle, iconv('CP1251', 'UTF-8', file_get_contents('shares_all.csv')));
	// rewind($handle);
	// fgetcsv($handle, 1000, ';');
	// while (($data = fgetcsv($handle, 1000, ';')) !== false){
		// try{
			// $sql = 'INSERT INTO quotes SET 
					// activeflag = 1
					// ,changedate = CURDATE()
					// ,fullname = :fullname
					// ,shortname = :shortname
					// ,englishname = :englishname
					// ,acronym = :acronym
					// ,companyid = :companyid
					// ,exchid = :exchangeid
					// ,privileged = :privileged';
			// $s = $pdo->prepare($sql);
			// $s->bindValue(':fullname', $data[1]);
			// $s->bindValue(':shortname', $data[2]);
			// $s->bindValue(':englishname', $data[9]);
			// $s->bindValue(':acronym', $data[0]);
			// $s->bindValue(':companyid', 2);
			// $s->bindValue(':exchangeid', 17);
			// $s->bindValue(':privileged', 0);
			// $s->execute();
		// }
		// catch (PDOException $e){
			// $error = 'Error adding values from file' . $e->getMessage();
			// include 'error.html.php';
			// exit();
		// }		
	// }
	// fclose($handle);


	// if(!isset($_COOKIE['visits'])){
		// $_COOKIE['visits'] = 0;
	// }
	// $visits = $_COOKIE['visits'] + 1;
	// setcookie('visits',$visits,time() + 365 * 3600 * 24);
	// echo 'This is your visit number ' . $visits;
	
?>	