<?php
    class Order extends Quote{
        protected $_orid;
        protected $_ordate;
        protected $_ortype;
        protected $_brokerId;
        protected $_amount;
        protected $_amountLot;
        protected $_currencyId;
        protected $_price;
        protected $_stopLoss;
        protected $_stopPrice;
        protected $_takeProfit;
        protected $_takePrice;
        protected $_sumTotal;
        protected $_brokerRevenue;
        protected $_orcomment;
        protected $_parentId;

        public function __get($property){
            return $this->$property;
        }

        public function __construct($_orid){
            include 'db_new.inc.php';
            $sql = 'SELECT
                        ordate
                        ,ortype
                        ,brokerid
                        ,qid
                        ,amount
                        ,currencyid
                        ,price
                        ,stoploss
                        ,stopprice
                        ,takeprofit
                        ,takeprice
                        ,amountlot
                        ,total
                        ,brokerrevenue
                        ,orcomment
                        ,parentid
                        ,accountid
                    FROM orders
                    WHERE orid = :orid';
            try{
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':orid',$_orid);
                $stmt->execute();

            }catch(PDOException $e){
                $error = $e->getMessage();
                $redirect = '../error.html.php';
                header("Location: $redirect");
                exit;
            }
            $row = $stmt->fetch();
            if($row){
                parent::__construct($row['qid']);
                $this->_orid = $_orid;
                $this->_ordate = $row['ordate'];
                $this->_ortype = $row['ortype'];
                $this->_brokerId = $row['brokerid'];
                $this->_amount = $row['amount'];
                $this->_amountLot = $row['amountlot'];
                $this->_currencyId = $row['currencyid'];
                $this->_price = $row['price'];
                $this->_stopLoss = $row['stoploss'];
                $this->_stopPrice = $row['stopprice'];
                $this->_takeProfit = $row['takeprofit'];
                $this->_takePrice = $row['takeprice'];
                $this->_sumTotal = $row['total'];
                $this->_brokerRevenue = $row['brokerrevenue'];
                $this->_orcomment = $row['orcomment'];
                $this->_parentId = $row['parentid'];
            }

        }

        public static function getOrders($active=1){
            include 'db_new.inc.php';
            $orders = array();
            $sql = "SELECT orid FROM orders WHERE ActiveFlag = $active";
            foreach($pdo->query($sql) as $row){
                $orders[] = new Order($row['orid']);
            }
            return $orders;
        }
    }