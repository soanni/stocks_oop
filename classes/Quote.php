<?php
    class Quote extends Company implements JsonSerializable{
        protected $_qid;
        protected $_quoteName;
        protected $_quoteShortName;
        protected $_englishName;
        protected $_acronym;
        protected $_exchid;
        protected $_privileged;

        public function __construct($qid, $qName, $qShortName, $qEnglish, $qAcronym, $exchid, $priveleged, $compid, $compName,$compWeb, $countryId, $countryName, $countryAcronym){
            parent::__construct($compid,$compName,$compWeb,$countryId, $countryName, $countryAcronym);
            $this->_qid = $qid;
            $this->_quoteName = $qName;
            $this->_quoteShortName = $qShortName;
            $this->_englishName = $qEnglish;
            $this->_acronym = $qAcronym;
            $this->_exchid = $exchid;
            $this->_privileged = $priveleged;
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
            include '../helpers/db_new.inc.php';
            $quotes = array();
            try{
                $sql = "SELECT
                            q.qid
                            ,q.fullname
                            ,q.shortname
                            ,q.englishname
                            ,q.acronym as qAcronym
                            ,q.exchid
                            ,c.companyid
                            ,c.companyname
                            ,c.web
                            ,cc.countryid
                            ,cc.countryname
                            ,cc.acronym as ccAcronym
                            ,q.privileged
                        FROM quotes q
                        INNER JOIN companies c USING(companyid)
                        INNER JOIN countries cc USING(countryid)";
                if(isset($compid) && isset($exchid)){
                    $sql .= " WHERE q.exchid = :exchid AND q.companyid = :compid";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':exchid',$exchid);
                    $stmt->bindParam(':compid',$compid);
                    $stmt->execute();
                    while($row = $stmt->fetch()){
                        $quotes[]   = new Quote($row['qid'],$row['fullname'],$row['shortname'],$row['englishname'],
                                                $row['qAcronym'],$row['exchid'],$row['privileged'],$row['companyid'],$row['companyname'],$row['web'],$row['countryid']
                                                ,$row['countryname'],$row['ccAcronym']);
                    }
                }else{
                    foreach($pdo->query($sql) as $row){
                        $quotes[]   = new Quote($row['qid'],$row['fullname'],$row['shortname'],$row['englishname'],
                                                $row['qAcronym'],$row['exchid'],$row['privileged'],$row['companyid'],$row['companyname'],$row['web'],$row['countryid']
                                                ,$row['countryname'],$row['ccAcronym']);
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