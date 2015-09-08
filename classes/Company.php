<?php

    class Company extends Country{
        protected $companyId;
        protected $companyName;
        protected $companyWeb;
        protected $countryId;
        private $activeFlag;

        public function __construct($id){
            include 'db_new.inc.php';
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
                $this->companyId = $id;
                $this->companyName = $row['companyname'];
                $this->companyWeb = $row['web'];
            }
        }

        ///////////////// getters and setters /////////////////////////////////

        public function __get($property){
            return $this->$property;
        }

        public function getCompanyId()
        {
            return $this->companyId;
        }

        public function setCompanyId($companyId)
        {
            $this->companyId = $companyId;
        }

        public function getCompanyName()
        {
            return $this->companyName;
        }

        public function setCompanyName($companyName)
        {
            $this->companyName = $companyName;
        }

        public function getCompanyWeb()
        {
            return $this->companyWeb;
        }

        public function setCompanyWeb($companyWeb)
        {
            $this->companyWeb = $companyWeb;
        }

        public function getCountryId()
        {
            return $this->countryId;
        }

        public function setCountryId($countryId)
        {
            $this->countryId = $countryId;
        }

        public function getActiveFlag()
        {
            return $this->activeFlag;
        }

        public function setActiveFlag($activeFlag)
        {
            $this->activeFlag = $activeFlag;
        }

        // static
        public static function getCompanies(){
            include 'db_new.inc.php';
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