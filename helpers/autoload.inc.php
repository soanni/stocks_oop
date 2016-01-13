<?php

spl_autoload_register(function($className){
    require_once "../classes/$className" . '.php';
});

spl_autoload_register(function($className){
    $parts = explode('_',$className);
    if(count($parts) > 1){
        $filename = implode(DIRECTORY_SEPARATOR,$parts) . '.php';
        require_once '../classes/' . $filename;
    }
},true,true);