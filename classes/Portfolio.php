<?php

class Portfolio{
    protected $_date;
    protected $_quotes = array();
    protected $_priceOnDate;

    public function __construct(){
        include_once('../helpers/db_new.inc.php');
    }
}