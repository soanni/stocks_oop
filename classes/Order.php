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

        public function __construct($_orid,$_ordate,$_ortype,$_brokerId,$_exchid,$_qid,$_qName,$_qShortName, $_qEnglish, $_qAcronym
                                    ,$_privileged,$_companyid, $_compName,$_compWeb, $_countryId, $_countryName, $_countryAcronym
                                    ,$_amount,$_amountLot,$_currencyId,$_price,$_stopLoss,$_stopPrice,$_takeProfit,$_takePrice,$_sumTotal
                                    ,$_brokerRevenue,$_orcomment,$_parentId){
            parent::__construct($_qid,$_qName,$_qShortName,$_qEnglish,$_qAcronym,$_exchid,$_privileged
                                ,$_companyid,$_compName,$_compWeb,$_countryId,$_countryName,$_countryAcronym);
            $this->_orid = $_orid;
            $this->_ordate = $_ordate;
            $this->_ortype = $_ortype;
            $this->_brokerId = $_brokerId;
            $this->_amount = $_amount;
            $this->_amountLot = $_amountLot;
            $this->_currencyId = $_currencyId;
            $this->_price = $_price;
            $this->_stopLoss = $_stopLoss;
            $this->_stopPrice = $_stopPrice;
            $this->_takeProfit = $_takeProfit;
            $this->_takePrice = $_takePrice;
            $this->_sumTotal = $_sumTotal;
            $this->_brokerRevenue = $_brokerRevenue;
            $this->_orcomment = $_orcomment;
            $this->_parentId = $_parentId;
        }

        public static function getOrders($active=1){
            include '../helpers/db_new.inc.php';
            $orders = array();
            $sql = "SELECT ord.orid
                        ,ord.ordate
                        ,ord.ortype
                        ,ord.brokerid
                        ,ord.exchid
                        ,ord.companyid
                        ,c.companyname
                        ,c.web
                        ,cc.countryid
                        ,cc.countryname
                        ,cc.acronym as countryAcronym
                        ,ord.qid
                        ,q.fullname
                        ,q.shortname
                        ,q.englishname
                        ,q.acronym as quoteAcronym
                        ,q.privileged
                        ,ord.amount
                        ,ord.amountlot
                        ,ord.currencyid
                        ,ord.price
                        ,ord.stoploss
                        ,ord.stopprice
                        ,ord.takeprofit
                        ,ord.takeprice
                        ,ord.total
                        ,ord.brokerrevenue
                        ,ord.orcomment
                        ,ord.parentid
                    FROM orders ord
                    INNER JOIN quotes q ON ord.qid = q.qid
                    INNER JOIN companies c ON c.companyid = ord.companyid
                    INNER JOIN countries cc ON c.countryid = cc.countryid
                    WHERE ord.ActiveFlag = $active";
            foreach($pdo->query($sql) as $row){
                $orders[] = new Order($row['orid'],$row['ordate'],$row['ortype'],$row['brokerid'],$row['exchid']
                    ,$row['qid'],$row['fullname'],$row['shortname'],$row['englishname'],$row['quoteAcronym'],$row['privileged']
                    ,$row['companyid'],$row['companyname'],$row['web'],$row['countryid'],$row['countryname'],$row['countryAcronym']
                    ,$row['amount'],$row['amountlot'],$row['currencyid'],$row['price'],$row['stoploss'],$row['stopprice'],$row['takeprofit']
                    ,$row['takeprice'],$row['total'],$row['brokerrevenue'],$row['orcomment'],$row['parentid']);
            }
            return $orders;
        }
    }