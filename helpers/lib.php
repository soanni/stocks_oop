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

class Country{
    public $id;
    public $name;
    public $acronym;

    public function __construct($id,$name,$acronym){
        $this->id = $id;
        $this->name = $name;
        $this->acronym = $acronym;
        return true;
    }

    // static methods ////////////////////////////////

    //select
    public static function getCountries($id=NULL){
        include 'db_new.inc.php';
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

class Currency{
    public $id;
    public $name;
    public $acronym;
    public $country;

    public function __construct($id,$name,$acronym,$country){
        $this->id = $id;
        $this->name = $name;
        $this->acronym = $acronym;
        $this->country = $country;
        return true;
    }

    // static methods //////////////////////////////////////////

    //select
    public static function getCurrencies($id=NULL){
        include 'db_new.inc.php';
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
        include 'db_new.inc.php';
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

class Company{
    protected $companyId;
    protected $companyName;
    protected $companyWeb;
    protected $countryId;
    private $activeFlag;

    ///////////////// getters and setters /////////////////////////////////

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

}

class Quote extends Company{

}



