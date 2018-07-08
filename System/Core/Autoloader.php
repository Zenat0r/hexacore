<?php

namespace Hexacore;

class Autoloader {

    public static function register(){
        spl_autoload_register([__CLASS__, "autoload"]);
    }

    public static function autoload(String $class){
        if(preg_match("^\\?App\\", $class)){
            str_replace("App\\", "", $class);
            str_replace("\\","/", $class);

            require __DIR__ . "../../App/src/" . $class . ".php";
        }
        else if(preg_match("^\\?Hexacore\\", $class)){
            str_replace("Hexacore\\", "", $class);
            str_replace("\\","/", $class);
            
            require $class . ".php";
        }
    }
}