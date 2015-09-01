<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stocks_oop/classes/Date.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stocks_oop/classes/Validator.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stocks_oop/classes/Currency.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stocks_oop/classes/Exchange.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stocks_oop/classes/Company.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stocks_oop/classes/Quote.php';

    $date = new Pos_Date();
    $now = $date->mysql;
    $exchanges = Exchange::getExchanges();
    $companies = Company::getCompanies();
    $quotes = Quote::getQuotes();
    $currencies = Currency::getCurrencies();
    $missing = null;
    $errors = null;
    if(isset($_POST['submit_order'])){
        $required = array('ordate','ortype','exchange','company','quote','amount'
                        ,'amountlot','currency','price','sumtotal','brokerrevenue');
        $valid = new Pos_Validator($required);
        $valid->isInt('amount',1);
        $valid->isInt('amountlot',1);
        $valid->isFloat('price');
        $valid->isFloat('sumtotal');
        $valid->isFloat('brokerrevenue');
        $valid->isFloat('stopprice');
        $valid->isFloat('takeprice');
        $valid->removeTags('comment');
        $valid->noFilter('ordate');
        $valid->noFilter('ortype');
        $valid->noFilter('exchange');
        $valid->noFilter('company');
        $valid->noFilter('quote');
        $valid->noFilter('currency');
        //$valid->useEntities('comment');
        $validate = $valid->validateInput();
        $missing = $valid->getMissing();
        $errors = $valid->getErrors();
        if(!isDate($_POST['ordate'])){
            $errors['ordate'] = "Invalid data supplied. Correct date format YYYY-mm-dd";
        }
        $insertOK = false;
        if(!$errors && !$missing){
            $redirect = 'http://localhost/stocks_oop/dashboard/index.php';
            $stoploss = isset($_POST['stoploss'])?1:0;
            $takeprofit = isset($_POST['takeprofit'])?1:0;
            $sql = "INSERT INTO orders
                        (ordate,
                        ortype,
                        brokerid,
                        exchid,
                        companyid,
                        qid,
                        amount,
                        currencyid,
                        price,
                        stoploss,
                        stopprice,
                        takeprofit,
                        takeprice,
                        amountlot,
                        total,
                        brokerrevenue,
                        orcomment,
                        parentid,
                        changedate,
                        activeflag,
                        accountid)
                    VALUES
                        (:ordate,
                        :ortype,
                        1,
                        :exchid,
                        :companyid,
                        :qid,
                        :amount,
                        :currencyid,
                        :price,
                        :stoploss,
                        :stopprice,
                        :takeprofit,
                        :takeprice,
                        :amountlot,
                        :total,
                        :brokerrevenue,
                        :orcomment,
                        NULL,
                        NOW(),
                        1,
                        1)";
            try{
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':ordate',$_POST['ordate']);
                $stmt->bindParam(':ortype',$_POST['ortype']);
                $stmt->bindParam(':exchid',$_POST['exchange']);
                $stmt->bindParam(':companyid',$_POST['company']);
                $stmt->bindParam(':qid',$_POST['quote']);
                $stmt->bindParam(':amount',$_POST['amount']);
                $stmt->bindParam(':currencyid',$_POST['currency']);
                $stmt->bindParam(':price',$_POST['price']);
                $stmt->bindParam(':amountlot',$_POST['amountlot']);
                $stmt->bindParam(':stoploss',$stoploss);
                $stmt->bindParam(':stopprice',$_POST['stopprice']);
                $stmt->bindParam(':takeprofit',$takeprofit);
                $stmt->bindParam(':takeprice',$_POST['takeprice']);
                $stmt->bindParam(':total',$_POST['sumtotal']);
                $stmt->bindParam(':brokerrevenue',$_POST['brokerrevenue']);
                $stmt->bindParam(':orcomment',$_POST['comment']);
                $stmt->execute();
                $insertOK = $stmt->rowCount();
            }catch(PDOException $e){
                $error = 'Error adding submitted order.' . $e->getMessage();
            }
            if($insertOK){
                header("Location: $redirect");
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Order Form</title>
        <link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
        <link href = "../js/jquery-ui/jquery-ui.min.css" rel = "stylesheet" type = "text/css" />
        <style type="text/css">
            .warning {
                color: #f00;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <?php
            //if(isset($error)){
            //    echo '<div class="warning">';
            //    echo "<p>$error</p></div>";
            //}
            if($missing){
                echo '<div class="warning">';
                echo '<br>The following fields have not been filled in';
                echo '<ul>';
                foreach($missing as $field){
                    echo '<li>' . $field . '</li>';
                }
                echo '</ul></div>';
            }
        ?>
        <form id="addorder" action="" method="post">
            <div>
                <label for = "ordate"
                    <?php
                        if(isset($errors['ordate'])){
                            echo "<span class='warning'>" . $errors['ordate'] . "</span>";
                        }
                    ?>>Order date:</label>
                <input type="text" name="ordate" id="ordate"
                       value="<?php
                                   if(isset($_POST['ordate']) && !$insertOK){
                                       echo $_POST['ordate'];
                                   }elseif(isset($ordate) && $ordate != ''){
                                       htmlout($ordate);
                                   }else{
                                       echo $now;
                                   }
                               ?>" autofocus>
            </div>
            <div>
                <label for="ortype"
                    <?php
                        if(isset($errors['ortype'])){
                            echo "<span class='warning'>" . $errors['ortype'] . "</span>";
                        }
                    ?>>Order type:</label>
                <select name="ortype" id="ortype">
                    <option value="">Select one</option>
                    <option value="1"
                        <?php
                            if ($ortype == 1){
                                echo ' selected';
                            }
                            if(isset($_POST['ortype']) && !$insertOK){
                                if($_POST['ortype'] == 1){
                                    echo ' selected';
                                }
                            }
                        ?>>Buy</option>
                    <option value="2"
                        <?php
                            if ($ortype == 2){
                                echo ' selected';
                            }
                            if(isset($_POST['ortype']) && !$insertOK){
                                if($_POST['ortype'] == 2){
                                    echo ' selected';
                                }
                            }
                        ?>>Sell</option>
                </select>
            </div>
            <div>
                 <label for="exchange"
                     <?php
                        if(isset($errors['exchange'])){
                            echo "<span class='warning'>" . $errors['exchange'] . "</span>";
                        }
                    ?>>Exchange: </label>
                <select name = "exchange" id="exchange">
                    <option value="">Select one</option>
                    <?php foreach ($exchanges as $exchange): ?>
                        <option value="<?php htmlout($exchange->getId()); ?>"
                            <?php
                                if ($exchange->getId() == $exchangeid){
                                    echo ' selected';
                                }
                                if(isset($_POST['exchange']) && !$insertOK){
                                    if($_POST['exchange'] == $exchange->getId()){
                                        echo ' selected';
                                    }
                                }
                            ?>>
                            <?php
                                htmlout($exchange->getName());
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="company"
                    <?php
                        if(isset($errors['company'])){
                            echo "<span class='warning'>" . $errors['company'] . "</span>";
                        }
                    ?>>Company: </label>
                <select name = "company" id="company">
                    <option value="">Select one</option>
                    <?php foreach ($companies as $company): ?>
                        <option value="<?php htmlout($company->getCompanyId()); ?>"
                            <?php
                                if ($company->getCompanyId() == $companyid){
                                    echo ' selected';
                                }
                                if(isset($_POST['company']) && !$insertOK){
                                    if($_POST['company'] == $company->getCompanyId()){
                                        echo ' selected';
                                    }
                                }
                            ?>>
                            <?php
                                htmlout($company->getCompanyName());
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="quote"
                    <?php
                        if(isset($errors['quote'])){
                            echo "<span class='warning'>" . $errors['quote'] . "</span>";
                        }
                    ?>>Quote: </label>
                <select name = "quote" id="quote">
                    <option value="">Select one</option>
                    <?php foreach ($quotes as $quote): ?>
                        <option value="<?php htmlout($quote->getQid()); ?>"
                            <?php
                                if ($quote->getQid() == $quoteid){
                                    echo ' selected';
                                }
                                if(isset($_POST['quote']) && !$insertOK){
                                    if($_POST['quote'] == $quote->getQid()){
                                        echo ' selected';
                                    }
                                }
                            ?>>
                            <?php
                                htmlout($quote->getQuoteName());
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="amount"
                    <?php
                        if(isset($errors['amount'])){
                            echo "<span class='warning'>" . $errors['amount'] . "</span>";
                        }
                    ?>>Amount:</label>
                <input type="number" name="amount" id="amount" value="<?php
                            if(isset($_POST['amount']) && !$insertOK){
                                echo htmlout($_POST['amount']);
                            }else{
                                htmlout($amount);
                            }
                        ?>">
            </div>
            <div>
                <label for="amountlot"
                    <?php
                        if(isset($errors['amountlot'])){
                            echo "<span class='warning'>" . $errors['amountlot'] . "</span>";
                        }
                    ?>>Amount (lots):</label>
                <input type="number" name="amountlot" id="amountlot" value="<?php
                            if(isset($_POST['amountlot']) && !$insertOK){
                                echo (int)$_POST['amountlot'];
                            }else {
                                htmlout($amountlot);
                            }
                        ?>">
            </div>
            <div>
                <label for="currency"
                    <?php
                        if(isset($errors['currency'])){
                            echo "<span class='warning'>" . $errors['currency'] . "</span>";
                        }
                    ?>>Currency: </label>
                <select name = "currency" id="currency">
                    <option value="">Select one</option>
                    <?php foreach ($currencies as $currency): ?>
                        <option value="<?php htmlout($currency->getCurrencyid()); ?>"
                            <?php
                                if ($currency->getCurrencyid() == $currencyid){
                                    echo ' selected';
                                }
                                if(isset($_POST['currency']) && !$insertOK){
                                    if($_POST['currency'] == $currency->getCurrencyId()){
                                        echo ' selected';
                                    }
                                }
                            ?>>
                            <?php
                                htmlout($currency->getCurrencyName());
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="price"
                    <?php
                        if(isset($errors['price'])){
                            echo "<span class='warning'>" . $errors['price'] . "</span>";
                        }
                    ?>>Price: </label>
                <input type="number" name="price" id="price" value="<?php
                        if(isset($_POST['price']) && !$insertOK){
                            echo (int)$_POST['price'];
                        }else {
                            htmlout($price);
                        }
                    ?>" step="<?php htmlout($step);?>">
            </div>
            <div>
                <label for="stoploss"
                    <?php
                        if(isset($errors['stoploss'])){
                            echo "<span class='warning'>" . $errors['stoploss'] . "</span>";
                        }
                    ?>>Stop-loss:</label>
                <input type="checkbox" name="stoploss" id="stoploss"
                    <?php
                        if ($stoploss || isset($_POST['stoploss'])){
                            echo ' checked';
                        }
                    ?>>
            </div>
            <div>
                <label for="stopprice"
                    <?php
                        if(isset($errors['stopprice'])){
                            echo "<span class='warning'>" . $errors['stopprice'] . "</span>";
                        }
                    ?>>Stop-loss price: </label>
                <input type="number" name="stopprice" id="stopprice" value="<?php
                    if(isset($_POST['stopprice']) && !$insertOK){
                        echo (int)$_POST['stopprice'];
                    }else {
                        htmlout($stopprice);
                    }
                ?>" step="<?php htmlout($step);?>">
            </div>
            <div>
                <label for="takeprofit"
                    <?php
                        if(isset($errors['takeprofit'])){
                            echo "<span class='warning'>" . $errors['takeprofit'] . "</span>";
                        }
                    ?>>Take-profit:</label>
                <input type="checkbox" name="takeprofit" id="takeprofit"
                    <?php
                    if ($takeprofit || isset($_POST['takeprofit'])){
                        echo ' checked';
                    }
                    ?>>
            </div>
            <div>
                <label for="takeprice"
                    <?php
                        if(isset($errors['takeprice'])){
                            echo "<span class='warning'>" . $errors['takeprice'] . "</span>";
                        }
                    ?>>Take-profit price: </label>
                <input type="number" name="takeprice" id="takeprice" value="<?php
                        if(isset($_POST['takeprice']) && !$insertOK){
                            echo (int)$_POST['takeprice'];
                        }else {
                            htmlout($takeprice);
                        }
                    ?>" step="<?php htmlout($step);?>">
            </div>
            <div>
                <label for="sumtotal"
                    <?php
                        if(isset($errors['sumtotal'])){
                            echo "<span class='warning'>" . $errors['sumtotal'] . "</span>";
                        }
                    ?>>Sum total: </label>
                <input name="sumtotal" id="sumtotal" value ="<?php
                        if(isset($_POST['sumtotal']) && !$insertOK){
                            echo (int)$_POST['sumtotal'];
                        }else {
                            htmlout($sumtotal);
                        }
                    ?>" readonly>
            </div>
            <div>
                <label for="brokerrevenue"
                    <?php
                        if(isset($errors['brokerrevenue'])){
                            echo "<span class='warning'>" . $errors['brokerrevenue'] . "</span>";
                        }
                    ?>>Broker revenue: </label>
                <input name="brokerrevenue" id="brokerrevenue" value="<?php
                        if(isset($_POST['brokerrevenue']) && !$insertOK){
                            echo (int)$_POST['brokerrevenue'];
                        }else {
                            htmlout($brokerrevenue);
                        }
                    ?>" readonly>
            </div>
            <div>
                <label for="comment"
                    <?php
                        if(isset($errors['comment'])){
                            echo "<span class='warning'>" . $errors['comment'] . "</span>";
                        }
                    ?>>Comment:</label>
                <textarea name="comment" rows="10" cols="60" placeholder="Comment..."><?php
                        if(isset($_POST['comment'])){
                            echo trim($_POST['comment']);
                        }
                    ?></textarea>
            </div>
            <div>
                <input type="hidden" name="orderid" value="<?php htmlout($orderid); ?>">
                <button type="reset">Reset</button>
                <button type="submit" name="submit_order" value="<?php htmlout($button); ?>">Submit</button>
            </div>
        </form>

        <script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="../js/date.js"></script>
        <script type="text/javascript" src="script.js"></script>-
    </body>
</html>