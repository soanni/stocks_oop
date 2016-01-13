<?php
    class Currency{
        protected $_currencyid;
        protected $_currencyName;
        protected $_currencyAcronym;
        protected $_currencyCountry;

        public function __construct($id,$name,$acronym,$country){
            $this->_currencyid = $id;
            $this->_currencyName = $name;
            $this->_currencyAcronym = $acronym;
            $this->_currencyCountry = $country;
        }

        ///////////////// getters /////////////////

        public function getCurrencyid()
        {
            return $this->_currencyid;
        }

        public function getCurrencyName()
        {
            return $this->_currencyName;
        }

        public function getCurrencyAcronym()
        {
            return $this->_currencyAcronym;
        }

        public function getCurrencyCountry()
        {
            return $this->_currencyCountry;
        }

        // static methods //////////////////////////////////////////

        //select
        public static function getCurrencies($id=NULL){
            include '../helpers/db_new.inc.php';
            $currencies = array();
            try{
                $sql = 'SELECT cc.countryname as country
                           ,c.acronym
                           ,c.curid
                           ,c.curname
                    FROM currencies c
                    INNER JOIN countries cc ON cc.countryid = c.countryid';
                if(!is_null($id)){
                    $sql .= ' WHERE c.curid = :id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id',$id);
                    $stmt->execute();
                }else{
                    $stmt = $pdo->query($sql);
                }
            }
            catch (PDOException $e){
                $error = 'Error fetching currencies: ' . $e->getMessage();
                include 'error.html.php';
                exit();
            }
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($currencies,new Currency($row['curid'],$row['curname'],$row['acronym'],$row['country']));
            }
            return $currencies;
        }

        // insert

        public static function insertCurrency($name,$acronym,$country){
            include '../helpers/db_new.inc.php';
            try{
                $sql = 'INSERT INTO currencies SET curname = :name, acronym = :acronym, countryid = :countryid';
                $s = $pdo->prepare($sql);
                $s->bindValue(':name', $name);
                $s->bindValue(':acronym', $acronym);
                $s->bindValue(':countryid', $country);
                $s->execute();
            }
            catch (PDOException $e){
                $error = 'Error adding submitted currency.';
                include 'error.html.php';
                exit();
            }

            return $pdo->lastInsertId();
        }


    }