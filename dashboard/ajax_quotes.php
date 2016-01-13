<?php
    if(isset($_POST['ajax_companyid']) && isset($_POST['ajax_exchid'])){
        $quotes = Quote::getQuotes($_POST['ajax_companyid'],$_POST['ajax_exchid']);
        if(empty($quotes)){
            echo 'Error 402';
        }else{
            echo json_encode($quotes);
        }
    }
