<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Order Form</title>
        <link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
        <link href = "../js/jquery-ui/jquery-ui.min.css" rel = "stylesheet" type = "text/css" />
    </head>
    <body>
        <form id="addorder" action="" method="post">
            <div>
                <label for = "ordate">Order date:</label>
                <input type="text" name="ordate" id="ordate" value="<?php htmlout($ordate);?>">
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
                    <option value="2"<?php
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
                        <option value="<?php htmlout($exchange['id']); ?>"
                            <?php
                            if ($exchange['id'] == $exchangeid){
                                echo ' selected';
                            }
                            ?>>
                            <?php
                            htmlout($exchange['name']);
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
                        <option value="<?php htmlout($company['id']); ?>"
                            <?php
                            if ($company['id'] == $companyid){
                                echo ' selected';
                            }
                            ?>>
                            <?php
                            htmlout($company['name']);
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
                        <option value="<?php htmlout($quote['qid']); ?>"
                            <?php
                            if ($quote['qid'] == $quoteid){
                                echo ' selected';
                            }
                            ?>>
                            <?php
                            htmlout($quote['fullname']);
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
                        <option value="<?php htmlout($currency['id']); ?>"
                            <?php
                            if ($currency['id'] == $currencyid){
                                echo ' selected';
                            }
                            ?>>
                            <?php
                            htmlout($currency['name']);
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
                <button type="submit" value="<?php htmlout($button); ?>">Submit</button>
            </div>
        </form>

        <script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="../js/date.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </body>
</html>