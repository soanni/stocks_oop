<?php
    class Exchange{
        private $id;
        private $name;
        private $web;

        public function __construct($name,$id,$web){
            $this->id = $id;
            $this->name = $name;
            $this->web = $web;
            return true;
        }

        ////////////////////// getters and setters ////////////////////////////////////////

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function getWeb()
        {
            return $this->web;
        }

        public function setWeb($web)
        {
            $this->web = $web;
        }

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        //////////////// static methods ///////////////////////////////

        // select
        public static function getExchanges($id = NULL){
            include 'db_new.inc.php';
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
                include 'error.html.php';
                exit();
            }
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($exchanges,new Exchange($row['exchname'],$row['exchid'],$row['web']));
            }
            return $exchanges;
        }

        // update

        public static function updateExchange($id,$name,$web){
            include 'db_new.inc.php';

            try{
                $sql = 'UPDATE exchanges SET exchname = :name,web = :web WHERE exchid = :id';
                $s = $pdo->prepare($sql);
                $s->execute(array(':id'=>$id,':name'=>$name,':web'=>$web));
            }
            catch (PDOException $e){
                $error = 'Error updating submitted exchange.';
                include 'error.html.php';
                exit();
            }

            return $s->rowCount();
        }

        // insert

        public static function insertExchange($name,$web){
            include 'db_new.inc.php';
            try{
                $sql = 'INSERT INTO exchanges SET exchname = :name, web = :web';
                $s = $pdo->prepare($sql);
                $s->execute(array(':name'=>$name,':web'=>$web));
            }
            catch (PDOException $e){
                $error = 'Error adding submitted exchange.';
                include 'error.html.php';
                exit();
            }
            return $pdo->lastInsertId();
        }
    }