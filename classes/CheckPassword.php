<?php

class CheckPassword{
    protected $_password;
    protected $_minimumChars;
    protected $_minimumNumbers = 0;
    protected $_minimumSymbols = 0;
    protected $_mixedCase = false;
    protected $_errors = array();

    public function __construct($pass, $minChars = 8){
        $this->_password = $pass;
        $this->_minimumChars = $minChars;
    }

    public function requireMixedCase(){
        $this->_mixedCase = true;
    }

    public function requireNumbers($num = 1){
        if(is_numeric($num) && $num > 0){
            $this->_minimumNumbers = (int) $num;
        }
    }

    public function requireSymbols($num = 1){
        if(is_numeric($num) && $num > 0){
            $this->_minimumSymbols = (int) $num;
        }
    }

    public function check(){
        if(preg_match('/\s/',$this->_password)){
            $this->_errors[] = 'Password must not contain spaces';
        }

        if(strlen($this->_password) < $this->_minimumChars){
            $this->_errors[]="Password must be at least ". $this->_minimumChars . " characters long";
        }

        if($this->_mixedCase){
            $pattern = '/(?=.*[a-z])(?=.*[A-Z])/';
            if(!preg_match($pattern,$this->_password)){
                $this->_errors[] = "Password must contain at least one UPPER case and one lower case letters";
            }
        }

        if($this->_minimumNumbers){
            $pattern = '/\d/';
            $found = preg_match_all($pattern,$this->_password,$matches);
            if($found < $this->_minimumNumbers){
                $this->_errors[] = "Password must contain minimum $this->_minimumNumbers numbers";
            }
        }

        if($this->_minimumSymbols){
            $pattern = "/[-!$%^&*(){}<>[\]'" . '"|#@:;.,?+=_\/\~]/';
            $found = preg_match_all($pattern,$this->_password,$matches);
            if($found < $this->_minimumSymbols){
                $this->_errors[] = "Password must contain minimum $this->_minimumSymbols nonalphanumeric symbols";
            }
        }


         return $this->_errors ? false : true;
    }

    public function getErrors(){
        return $this->_errors;
    }
}