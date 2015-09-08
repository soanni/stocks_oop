<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
    require_once 'autoload.inc.php';
    //var_dump(spl_autoload_functions());
    $orders = Order::getOrders();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>List of orders</title>
        <link href = "../css/style.css" rel = "stylesheet" type = "text/css" />
    </head>
    <body>
        <?php
            if(isset($error)){
                echo '<div class="warning">';
                echo "<p>$error</p></div>";
            }
            if(isset($success)){
                echo '<div class="warning">';
                echo "<p>$success</p></div>";
            }
        ?>
        <nav>
            <ul>
                <li><a href="?neworder">New Order</a></li>
                <li><a href="..">Back..</a></li>
                <li class="topofpage"><a href="#">Top of page</a></li>
            </ul>
        </nav>
        <table id="orders">
            <thead>
                <tr>
                    <th>Order date</th>
                    <th>SECID</th>
                    <th>Ortype</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Amount lots</th>
                    <th>S/L</th>
                    <th>S/L Price</th>
                    <th>T/P</th>
                    <th>T/P Price</th>
                    <th>Total</th>
                    <th>Broker revenue</th>
                    <th>Comment</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order){?>
                    <tr>
                        <td><?php
                                $date = new Pos_Date();
                                $date->setFromMySQL(substr($order->_ordate,0,strrpos($order->_ordate,' ')));
                                htmlout($date->dmy0);
                            ?></td>
                        <td><?php htmlout($order->_acronym);?></td>
                        <td><?php if($order->_ortype == 1){
                                        echo 'Buy';
                                    }elseif($order->_ortype == 2){
                                        echo 'Sell';
                                    }
                                    ?></td>
                        <td><?php htmlout((float)$order->_price);?></td>
                        <td><?php htmlout((int)$order->_amount);?></td>
                        <td><?php htmlout((int)$order->_amountLot);?></td>
                        <td><?php if($order->_stopLoss){
                                        echo 'Yes';
                                    }else{
                                        echo 'No';
                                    }
                                    ?></td>
                        <td><?php htmlout((float)$order->_stopPrice?(float)$order->_stopPrice:'');?></td>
                        <td><?php if($order->_takeProfit){
                                        echo 'Yes';
                                    } else{
                                        echo 'No';
                                    }?></td>
                        <td><?php htmlout((float)$order->_takePrice?(float)$order->_takePrice:'');?></td>
                        <td><?php htmlout((float)$order->_sumTotal);?></td>
                        <td><?php htmlout((float)$order->_brokerRevenue);?></td>
                        <td><?php htmlout($order->_orcomment);?></td>
                        <td>
                            <form id="options" method="post">
                                <input type="hidden" name="orid" value="<?php echo $order->_orid;?>">
                                <input type="submit" name="deleteOrder" value="Delete">
                                <input type="submit" name="editOrder" value="Edit">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>