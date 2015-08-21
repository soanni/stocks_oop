<?php
    include '../helpers/db_new.inc.php';
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
//        if(is_numeric($_POST['amount']) && is_numeric($_POST['amountlot'])
//            && is_numeric($_POST['price']) && is_numeric($_POST['stopprice'])
//            && is_numeric($_POST['takeprice']) && is_numeric($_POST['sumtotal'])
//            && is_numeric($_POST['brokerrevenue'])){

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
            $valid->useEntities('comment');

            $insertOK = false;
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
                            changedate)
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
                            NOW())";
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
                //include 'error.html.php';
                //exit();
            }
            if($OK){
                header("Location: $redirect");
                exit();
            }

        //}
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Order Form</title>
        <link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
        <link href = "../js/jquery-ui/jquery-ui.min.css" rel = "stylesheet" type = "text/css" />
    </head>
    <body>
        <?php
            if(isset($error)){
                echo "<p>$error</p>";
            }
        ?>
        <form id="addorder" action="" method="post">
            <div>
                <label for = "ordate">Order date:</label>
                <input type="text" name="ordate" id="ordate"
                       value="<?php
                                   if(isset($ordate) && $ordate != ''){
                                       htmlout($ordate);
                                   }else{
                                       echo $now;
                                   }
                               ?>">
            </div>
            <div>
                <label for="ortype">Order type:</label>
                <select name="ortype" id="ortype">
                    <option value="">Select one</option>
                    <option value="1"
                        <?php
                            if ($ortype == 1){
                                echo ' selected';
                            }
                        ?>>Buy</option>
                    <option value="2"
                        <?php
                            if ($ortype == 2){
                                echo ' selected';
                            }
                        ?>>Sell</option>
                </select>
            </div>
            <div>
                <label for="exchange">Exchange: </label>
                <select name = "exchange" id="exchange">
                    <option value="">Select one</option>
                    <?php foreach ($exchanges as $exchange): ?>
                        <option value="<?php htmlout($exchange->getId()); ?>"
                            <?php
                                if ($exchange->getId() == $exchangeid){
                                    echo ' selected';
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
                <label for="company">Company: </label>
                <select name = "company" id="company">
                    <option value="">Select one</option>
                    <?php foreach ($companies as $company): ?>
                        <option value="<?php htmlout($company->getCompanyId()); ?>"
                            <?php
                            if ($company->getCompanyId() == $companyid){
                                echo ' selected';
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
                <label for="quote">Quote: </label>
                <select name = "quote" id="quote">
                    <option value="">Select one</option>
                    <?php foreach ($quotes as $quote): ?>
                        <option value="<?php htmlout($quote->getQid()); ?>"
                            <?php
                            if ($quote->getQid() == $quoteid){
                                echo ' selected';
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
                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" value="<?php htmlout($amount); ?>">
            </div>
            <div>
                <label for="amountlot">Amount (lots):</label>
                <input type="number" name="amountlot" id="amountlot" value="<?php htmlout($amountlot); ?>">
            </div>
            <div>
                <label for="currency">Currency: </label>
                <select name = "currency" id="currency">
                    <option value="">Select one</option>
                    <?php foreach ($currencies as $currency): ?>
                        <option value="<?php htmlout($currency->getCurrencyid()); ?>"
                            <?php
                            if ($currency->getCurrencyid() == $currencyid){
                                echo ' selected';
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
                <label for="price">Price: </label>
                <input type="number" name="price" id="price" value="<?php htmlout($price); ?>" step="<?php htmlout($step);?>">
            </div>
            <div>
                <label for="stoploss">Stop-loss:</label>
                <input type="checkbox" name="stoploss" id="stoploss"
                    <?php
                    if ($stoploss){
                        echo ' checked';
                    }
                    ?>>
            </div>
            <div>
                <label for="stopprice">Stop-loss price: </label>
                <input type="number" name="stopprice" id="stopprice" value="<?php htmlout($stopprice); ?>" step="<?php htmlout($step);?>">
            </div>
            <div>
                <label for="takeprofit">Take-profit:</label>
                <input type="checkbox" name="takeprofit" id="takeprofit"
                    <?php
                    if ($takeprofit){
                        echo ' checked';
                    }
                    ?>>
            </div>
            <div>
                <label for="takeprice">Take-profit price: </label>
                <input type="number" name="takeprice" id="takeprice" value="<?php htmlout($takeprice); ?>" step="<?php htmlout($step);?>">
            </div>
            <div>
                <label for="sumtotal">Sum total: </label>
                <input type="number" name="sumtotal" id="sumtotal" value="<?php htmlout($sumtotal); ?>">
            </div>
            <div>
                <label for="brokerrevenue">Broker revenue: </label>
                <input type="number" name="brokerrevenue" id="brokerrevenue" value="<?php htmlout($brokerrevenue); ?>">
            </div>
            <div>
                <label for="comment">Comment:</label>
                <textarea name="comment" rows="10" cols="60">Comment...</textarea>
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
        <script type="text/javascript" src="script.js"></script>
    </body>
</html>