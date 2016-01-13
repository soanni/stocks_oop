<?php
    require_once '../helpers/autoload.inc.php';
	// SELECT LIST OF COUNTRIES

    $countries = Country::getCountries();

	// ADD AND EDIT CURRENCIES
	
	// ADD
	if (isset($_GET['addcurrency'])){
		$pageTitle = 'New Currency';
		$action = 'addform';
		$curname = '';
		$acronym = '';
		$id = '';
		$countryid = 0;
		$button = 'Add currency';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['addform'])){
        Currency::insertCurrency($_POST['curname'],$_POST['acronym'],$_POST['countryname']);
		header('Location: .');
		exit();
	}
		
	// SELECT THE LIST OF CURRENCIES //////////////////////////////////////////////////////

    $currencies = Currency::getCurrencies();
	include 'currencies.html.php';