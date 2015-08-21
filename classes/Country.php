<?php
    class Country{
        protected $_countryid;
        protected $_countryName;
        protected $_countryAcronym;

        public function __construct($id,$name,$acronym){
            $this->_countryid = $id;
            $this->_countryName = $name;
            $this->_countryAcronym = $acronym;
            return true;
        }

        // getters
        public function getCountryid()
        {
            return $this->_countryid;
        }

        public function getCountryName()
        {
            return $this->_countryName;
        }

        public function getCountryAcronym()
        {
            return $this->_countryAcronym;
        }

        // static methods ////////////////////////////////

        //select
        public static function getCountries($id=NULL){
            include '../helpers/db_new.inc.php';
            $countries = array();
            try{
                $sql = 'SELECT countryid,countryname,acronym FROM countries';
                if(!is_null($id)){
                    $sql .= ' WHERE countryid = :id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id',$id);
                    $stmt->execute();
                }else{
                    $stmt = $pdo->query($sql);
                }
            }
            catch (PDOException $e){
                $error = 'Error fetching countries: ' . $e->getMessage();
                include 'error.html.php';
                exit();
            }
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($countries,new Country($row['countryid'],$row['countryname'],$row['acronym']));
            }

            return $countries;

        }

        // update
        public static function updateCountry($id,$name,$acronym){
            include '../helpers/db_new.inc.php';
            try{
                $sql = 'UPDATE countries SET countryname = :name,acronym = :acronym WHERE countryid = :id';
                $s = $pdo->prepare($sql);
                $s->execute(array(':id'=>$id,':name'=>$name,':acronym'=>$acronym));
            }
            catch (PDOException $e){
                $error = 'Error updating submitted country.';
                include 'error.html.php';
                exit();
            }
            return $s->rowCount();
        }

        // insert
        public static function insertCountry($name,$acronym){
            include '../helpers/db_new.inc.php';

            try{
                $sql = 'INSERT INTO countries SET countryname = :name, acronym = :acronym';
                $s = $pdo->prepare($sql);
                $s->execute(array(':name'=>$name,':acronym'=>$acronym));
            }
            catch (PDOException $e){
                $error = 'Error adding submitted country.';
                include 'error.html.php';
                exit();
            }

            return $pdo->lastInsertId();
        }

    }