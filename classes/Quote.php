<?php
    class Quote extends Company implements JsonSerializable{
        protected $_qid;
        protected $_quoteName;
        protected $_quoteShortName;
        protected $_englishName;
        protected $_acronym;
        protected $_exchid;
        protected $_privileged;

        public function __construct($qid){
            include('db_new.inc.php');
            $sql = 'SELECT
                        fullname
                        ,shortname
                        ,englishname
                        ,acronym
                        ,exchid
                        ,companyid
                        ,privileged
                    FROM quotes
                    WHERE qid = :qid AND ActiveFlag = 1';
            try{
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':qid',$qid);
                $stmt->execute();
            }catch(PDOException $e){
                $error = $e->getMessage();
                $redirect = '../error.html.php';
                header("Location: $redirect");
                exit;
            }
            $row = $stmt->fetch();
            if($row){
                parent::__construct($row['companyid']);
                $this->_qid = $qid;
                $this->_quoteName = $row['fullname'];
                $this->_quoteShortName = $row['shortname'];
                $this->_englishName = $row['englishname'];
                $this->_acronym = $row['acronym'];
                $this->_exchid = $row['exchid'];
                $this->_privileged = $row['privileged'];
            }
        }

        // overriden
        public function jsonSerialize(){
            return array('qid'=>$this->_qid
                        ,'quoteName'=>$this->_quoteName
                        ,'quoteShortName'=>$this->_quoteShortName
                        ,'englishName'=>$this->_englishName
                        ,'acronym'=>$this->_acronym
                        ,'exchid'=>$this->_exchid
                        ,'privileged'=>$this->_privileged
                        ,'companyid'=>$this->companyId
                        ,'companyName'=>$this->companyName
                        ,'companyWeb'=>$this->companyWeb
                        ,'countryId'=>$this->_countryid
                        ,'countryName'=>$this->companyName
                        ,'countryAcronym'=>$this->_countryAcronym);
        }

        //////////////////////////// getters ////////////////////////////
        public function __get($property){
            return $this->$property;
        }

        public function getQid()
        {
            return $this->_qid;
        }

        public function getQuoteName()
        {
            return $this->_quoteName;
        }

        public function getQuoteShortName()
        {
            return $this->_quoteShortName;
        }

        public function getEnglishName()
        {
            return $this->_englishName;
        }

        public function getAcronym()
        {
            return $this->_acronym;
        }

        public function getExchid()
        {
            return $this->_exchid;
        }

        public function getPrivileged()
        {
            return $this->_privileged;
        }

        public static function getQuotes($compid = null, $exchid = null){
            include 'db_new.inc.php';
            $quotes = array();
            try{
                $sql = "SELECT qid FROM quotes";
                if(isset($compid) && isset($exchid)){
                    $sql .= " WHERE exchid = :exchid AND companyid = :compid";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':exchid',$exchid);
                    $stmt->bindParam(':compid',$compid);
                    $stmt->execute();
                    while($row = $stmt->fetch()){
                        $quotes[]   = new Quote($row['qid']);
                    }
                }else{
                    foreach($pdo->query($sql) as $row){
                        $quotes[]   = new Quote($row['qid']);
                    }
                }
            }catch(PDOException $e){
                $error = 'Error fetching quotes: ' . $e->getMessage();
                include 'error.html.php';
                exit();
            }
            return $quotes;
        }

    }