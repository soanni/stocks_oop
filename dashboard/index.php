<?php

    ///////////////////// NEW ORDER

    if(isset($_GET['neworder']) ) {
        $ordate = '';
        $ortype = 1;
        $exchangeid = 0;
        $companyid = 0;
        $quoteid = 0;
        $amount = 0;
        $amountlot = 0;
        $currencyid = 0;
        $price = 0;
        $step = 1;
        $stoploss = 0;
        $stopprice = 0;
        $takeprofit = 0;
        $takeprice = 0;
        $sumtotal = 0;
        $brokerrevenue = 0;
        $orderid = 0;
        $button = "Add order";

        include 'order.html.php';
        exit();
    }

    include 'securities.html.php';
