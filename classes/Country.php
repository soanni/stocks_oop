<?php
    class Country{
        protected $_countryid;
        protected $_countryName;
        protected $_countryAcronym;

        public function __construct($id){
            include 'db_new.inc.php';
            $sql = 'SELECT
                        countryname,
                        acronym
                    FROM countries
                    WHERE countryid = :id';
            try{
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id',$id);
                $stmt->execute();
            }catch(PDOException $e){
                $error = $e->getMessage();
                $redirect = '../error.html.php';
                header("Location: $redirect");
                exit;
            }
            $row = $stmt->fetch();
            if($row){
                $this->_countryid = $id;
                $this->_countryName = $row['countryname'];
                $this->_countryAcronym = $row['acronym'];
            }

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
            include 'db_new.inc.php';
            $countries = array();
            try{
                $sql = 'SELECT countryid FROM countries';
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
                array_push($countries,new Country($row['countryid']));
            }

            return $countries;

        }

        // update
        public static function updateCountry($id,$name,$acronym){
            include 'db_new.inc.php';
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
            include 'db_new.inc.php';

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