<?php

    class Company extends Country{
        protected $_companyId;
        protected $_companyName;
        protected $_companyWeb;
        protected $_countryId;
        private $_activeFlag;

        public function __construct($id){
            include '../helpers/db_new.inc.php';
            $sql = 'SELECT
                        companyname,
                        web,
                        countryid
                    FROM companies
                    WHERE companyid = :id';
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
                parent::__construct($row['countryid']);
                $this->_companyId = $id;
                $this->_companyName = $row['companyname'];
                $this->_companyWeb = $row['web'];
            }
        }

        ///////////////// getters and setters /////////////////////////////////

        public function __get($property){
            return $this->$property;
        }

        public function getCompanyId()
        {
            return $this->_companyId;
        }

        public function getCompanyName()
        {
            return $this->_companyName;
        }

        public function getCompanyWeb()
        {
            return $this->_companyWeb;
        }

        public function getCountryId()
        {
            return $this->_countryId;
        }

        public function getActiveFlag()
        {
            return $this->_activeFlag;
        }

        // static
        public static function getCompanies(){
            include '../helpers/db_new.inc.php';
            $companies = array();
            try{
                $sql = "SELECT companyid FROM companies WHERE ActiveFlag=1";
                foreach($pdo->query($sql) as $row) {
                    $companies[] = new Company($row['companyid']);
                }
            }catch(PDOException $e){
                $error = 'Error fetching companies: ' . $e->getMessage();
                include 'error.html.php';
                exit();
            }

            return $companies;
        }

    }