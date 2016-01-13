<?php
    require_once '../helpers/autoload.inc.php';

	// ADD AND EDIT COUNTRIES
	
	// ADD
	if (isset($_GET['addcountry'])){
		$pageTitle = 'New Country';
		$action = 'addform';
		$countryname = '';
		$acronym = '';
		$id = '';
		$button = 'Add country';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['addform'])){
        Country::insertCountry($_POST['countryname'],$_POST['acronym']);
		header('Location: .');
		exit();
	}
	
	//EDIT
	if (isset($_POST['action']) and $_POST['action'] == 'Edit'){
        $arr = Country::getCountries($_POST['id']);
        $row = $arr[0];
		$pageTitle = 'Edit Country';
		$action = 'editform';
		$countryname = $row->getCountryName();
		$acronym = $row->getCountryAcronym();
		$id = $row->_id;
		$button = 'Update country';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['editform'])){
        Country::updateCountry($_POST['id'],$_POST['countryname'],$_POST['acronym']);
		header('Location: .');
		exit();
	}
	
	// SELECT THE LIST OF COUNTRIES //////////////////////////////////////////////////////

    $countries = Country::getCountries();
	include 'countries.html.php';