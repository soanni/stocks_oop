<?php
    include '../helpers/db_new.inc.php';

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
        $step = '0.000001';
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

    if(isset($_POST['deleteOrder'])){
        $sql = 'UPDATE orders SET ActiveFlag = 0 WHERE orid = :orid';
        $orid = $_POST['orid'];
        try{
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':orid',$orid);
            $stmt->execute();
        }catch(PDOException $e){
            $error = 'Error updating order.' . $e->getMessage();
        }
        if($stmt->rowCount()){
            $success = "Order $orid updated successfully";
        }
    }

    include 'securities.html.php';
