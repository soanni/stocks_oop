<?php

spl_autoload_register(function($className){
    require_once $className . '.php';
});

spl_autoload_register(function($className){
    $parts = explode('_',$className);
    if(count($parts) > 1){
        $filename = $parts[0] . DIRECTORY_SEPARATOR . $parts[1] . '.php';
        require_once $filename;
    }
},true,true);