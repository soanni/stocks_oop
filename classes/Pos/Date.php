<?php

class Pos_Date extends DateTime {
    protected $_year;
    protected $_month;
    protected $_day;

    static public function dateDiff(Pos_Date $startdate, Pos_Date $enddate){
        $start = gmmktime(0,0,0,$startdate->_month,$startdate->_day,$startdate->_year);
        $end = gmmktime(0,0,0,$enddate->_month,$enddate->_day,$enddate->_year);
        return ($end - $start) / (60*60*24);
    }

    public function __construct($timezone = null){
        if($timezone){
            parent::__construct('now',$timezone);
        }else{
            parent::__construct('now');
        }
        $this->_year = (int) $this->format('Y');
        $this->_month = (int) $this->format('n');
        $this->_day = (int) $this->format('j');
    }

    public function modify(){
        throw new Exception("modify() has been disabled");
    }

    public function setTime($hours,$minutes,$seconds=0){
        if(!is_numeric($hours) || !is_numeric($minutes) || !is_numeric($seconds)){
            throw new Exception("setTime() needs 3 NUMERIC arguments (1 optional)");
        }
        $flag = false;
        if($hours < 0 || $hours > 23){
            $flag = true;
        }

        if($minutes < 0 || $minutes > 59){
            $flag = true;
        }

        if($seconds < 0 || $seconds > 59){
            $flag = true;
        }

        if($flag){
            throw new Exception("Out of range numeric");
        }

        parent::setTime($hours,$minutes,$seconds);

    }

    public function setDate($year,$month,$day){
        if(!is_numeric($year) || !is_numeric($month) || !is_numeric($day)){
            throw new Exception("setDate() needs 3 NUMERIC arguments");
        }

        if (!checkdate($month,$day,$year)){
            throw new Exception("Invalid Date");
        }

        parent::setDate($year,$month,$day);
        $this->_year = (int) $year;
        $this->_month = (int) $month;
        $this->_day = (int) $day;
    }

    public function setMDY($USDate){
        $arr = preg_split('{-/ :.}',$USDate);
        if(!is_array($arr) || count($arr) != 3){
            throw new Exception("setMDY expects date in MM/DD/YYYY format");
        }
        $this->setDate($arr[2],$arr[0],$arr[1]);
    }

    public function setDMY($EuroDate){
        $arr = preg_split('{-/ :.}',$EuroDate);
        if(!is_array($arr) || count($arr) != 3){
            throw new Exception("setDMY expects date in DD/MM/YYYY format");
        }
        $this->setDate($arr[2],$arr[1],$arr[0]);
    }

    public function setFromMySQL($MySQLDate){
        $arr = preg_split('{[-/ :.]}',$MySQLDate);
        if(!is_array($arr) || count($arr) != 3){
            throw new Exception("setFromMySQL expects date in YYYY-MM-DD format");
        }
        $this->setDate($arr[0],$arr[1],$arr[2]);
    }

    public function getMDY($leadZeros=false){
        if($leadZeros){
            return $this->format('m/d/Y');
        }else{
            return $this->format('n/j/Y');
        }
    }

    public function getDMY($leadZeros=false){
        if($leadZeros){
            return $this->format('d/m/Y');
        }else{
            return $this->format('j/n/Y');
        }
    }

    public function getMySqlFormat(){
        $this->format('Y-m-d');
    }

    public function getFullYear()
    {
        return $this->_year;
    }
    public function getYear()
    {
        return $this->format('y');
    }
    public function getMonth($leadingZero = false)
    {
        return $leadingZero ? $this->format('m') : $this->_month;
    }
    public function getMonthName()
    {
        return $this->format('F');
    }
    public function getMonthAbbr()
    {
        return $this->format('M');
    }
    public function getDay($leadingZero = false)
    {
        return $leadingZero ? $this->format('d') : $this->_day;
    }
    public function getDayOrdinal()
    {
        return $this->format('jS');
    }
    public function getDayName()
    {
        return $this->format('l');
    }
    public function getDayAbbr()
    {
        return $this->format('D');
    }

    public function addDays($numDays){
        if(!is_numeric($numDays) || $numDays < 1){
            throw new Exception("addDays() expects positive integer");
        }
        parent::modify("+" . intval($numDays). " days");
    }

    public function subDays($numDays){
        if(!is_numeric($numDays)){
            throw new Exception("subDays() expects positive integer");
        }
        parent::modify("-" . abs(intval($numDays)). " days");
    }

    public function addWeeks($numWeeks){
        if(!is_numeric($numWeeks) || $numWeeks < 1){
            throw new Exception("addWeeks() expects positive integer");
        }
        parent::modify("+" . intval($numWeeks). " weeks");
    }

    public function subWeeks($numWeeks){
        if(!is_numeric($numWeeks)){
            throw new Exception("subWeeks() expects positive integer");
        }
        parent::modify("-" . abs(intval($numWeeks)). " weeks");
    }

    public function addMonths($numMonths){
        if (!is_numeric($numMonths) || $numMonths < 1){
            throw new Exception("addMonths() expects positive integer");
        }
        $newValue = $this->_month + $numMonths;
        if($newValue <= 12){
            $this->_month = $newValue;
        }else{
            $remainder = $newValue % 12;
            if($remainder){
                $this->_month = $remainder;
                $this->_year += floor($newValue/12);
            }else{
                $this->_month = 12;
                $this->_year += ($newValue / 12) - 1;
            }
        }
        $this->checkLastDayOfMonth();
        parent::setDate($this->_year,$this->_month,$this->_day);
    }

    public function subMonths($numMonths){
        if(!is_numeric($numMonths)){
            throw new Exception("subMonths() expects integer");
        }

        $numMonths = abs(intval($numMonths));
        $newValue = $this->_month - $numMonths;
        if($newValue <= 12){
            $this->_month = $newValue;
        }else{
            $arr = range(12,1);
            $newValue = abs($newValue);
            $monthPosition = $newValue % 12;
            $this->_month = $arr[$monthPosition];
            if($monthPosition){
                $this->_year -= ceil($newValue/12);
            }else{
                $this->_year -= ceil($newValue/12) + 1;
            }
        }

        $this->checkLastDayOfMonth();
        parent::setDate($this->_year,$this->_month,$this->_day);
    }

    public function addYears($numYears){
        if(!is_numeric($numYears) || $numYears < 1){
            throw new Exception("addYears() expects positive integer");
        }
        $this->_year += $numYears;
        $this->checkLastDayOfMonth();
        parent::setDate($this->_year,$this->_month,$this->_day);
    }

    public function subYears($numYears){
        if(!is_numeric($numYears)){
            throw new Exception("addYears() expects integer");
        }
        $this->_year -= abs(intval($numYears));
        $this->checkLastDayOfMonth();
        parent::setDate($this->_year,$this->_month,$this->_day);
    }

    public function __toString()
    {
        return $this->format('l, F jS, Y');
    }

    public function __get($name){
        switch($name){
            case 'mdy':
                return $this->format('n/j/Y');
            case 'mdy0':
                return $this->format('m/d/Y');
            case 'dmy':
                return $this->format('j/n/Y');
            case 'dmy0':
                return $this->format('d/m/Y');
            case 'mysql':
                return $this->format('Y-m-d');
            case 'fullyear':
                return $this->_year;
            case 'year':
                return $this->format('y');
            case 'month':
                return $this->_month;
            case 'month0':
                return $this->format('m');
            case 'monthname':
                return $this->format('F');
            case 'monthabbr':
                return $this->format('M');
            case 'day':
                return $this->_day;
            case 'day0':
                return $this->format('d');
            case 'dayordinal':
                return $this->format('jS');
            case 'dayname':
                return $this->format('l');
            case 'dayabbr':
                return $this->format('D');
            default:
                return 'Invalid property';
        }
    }

    public function isLeap(){
        if($this->_year % 400 == 0 || ($this->_year % 4 == 0 && $this->_year % 100 != 0)){
            return true;
        }else{
            return false;
        }
    }

    final protected function checkLastDayOfMonth(){
        if(!checkdate($this->_month,$this->_day,$this->_year)){
            $use30 = array(4,6,9,11);
            if(in_array($this->_month,$use30)){
                $this->_day = 30;
            }else{
                $this->_day = $this->isLeap() ? 29 : 28;
            }
        }
    }

}