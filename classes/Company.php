<?php
    include 'Country.php';

    class Company extends Country{
        protected $companyId;
        protected $companyName;
        protected $companyWeb;
        protected $countryId;
        private $activeFlag;

        public function __construct($id,$name,$web,$country_id, $country_name, $acronym){
            parent::__construct($country_id, $country_name, $acronym);
            $this->companyId = $id;
            $this->companyName = $name;
            $this->companyWeb = $web;
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
            include '../helpers/db_new.inc.php';
            $companies = array();
            try{
                $sql = "SELECT
                            c.companyid,
                            cc.countryid,
                            c.companyname,
                            c.web,
                            cc.countryname,
                            cc.acronym
                        FROM companies c
                        INNER JOIN countries cc USING(countryid)
                        WHERE ActiveFlag=1";
                foreach($pdo->query($sql) as $row) {
                    $companies[] = new Company($row['companyid'],$row['companyname'],$row['web'],$row['countryid'],$row['countryname'],$row['acronym']);
                }
            }catch(PDOException $e){
                $error = 'Error fetching companies: ' . $e->getMessage();
                include 'error.html.php';
                exit();
            }

            return $companies;
        }

    }