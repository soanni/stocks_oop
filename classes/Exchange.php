<?php
    class Exchange{
        private $_id;
        private $_name;
        private $_web;

        public function __construct($name,$id,$web){
            $this->_id = $id;
            $this->_name = $name;
            $this->_web = $web;
        }

        ////////////////////// getters and setters ////////////////////////////////////////

        public function __get($property){
            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }

        public function getName()
        {
            return $this->_name;
        }

        public function getWeb()
        {
            return $this->_web;
        }


        public function getId()
        {
            return $this->_id;
        }

        //////////////// static methods ///////////////////////////////

        // select
        public static function getExchanges($id = NULL){
            include '../helpers/db_new.inc.php';
            $exchanges = array();
            try{
                $sql = 'SELECT exchid,exchname,web FROM exchanges';
                if (!is_null($id)){
                    $where = ' WHERE exchid = :id';
                    $sql .= $where;
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id',$id);
                    $stmt->execute();
                }else{
                    $stmt = $pdo->query($sql);
                }
            }
            catch (PDOException $e){
                $error = 'Error fetching exchanges: ' . $e->getMessage();
                include '../helpers/error.html.php';
                exit();
            }
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($exchanges,new Exchange($row['exchname'],$row['exchid'],$row['web']));
            }
            return $exchanges;
        }

        // update

        public static function updateExchange($id,$name,$web){
            include '../helpers/db_new.inc.php';

            try{
                $sql = 'UPDATE exchanges SET exchname = :name,web = :web WHERE exchid = :id';
                $s = $pdo->prepare($sql);
                $s->execute(array(':id'=>$id,':name'=>$name,':web'=>$web));
            }
            catch (PDOException $e){
                $error = 'Error updating submitted exchange.';
                include '../helpers/error.html.php';
                exit();
            }

            return $s->rowCount();
        }

        // insert

        public static function insertExchange($name,$web){
            include '../helpers/db_new.inc.php';
            try{
                $sql = 'INSERT INTO exchanges SET exchname = :name, web = :web';
                $s = $pdo->prepare($sql);
                $s->execute(array(':name'=>$name,':web'=>$web));
            }
            catch (PDOException $e){
                $error = 'Error adding submitted exchange.';
                include '../helpers/error.html.php';
                exit();
            }
            return $pdo->lastInsertId();
        }
    }