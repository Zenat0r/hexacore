<?php

namespace Hexacore\Core;

class Core{
    private static $core;

    public static function getCore(){
        if(is_null(self::$core)){
            self::$core = new Core();
        }   
        return self::$core;
    }

    private function __contructor(){

    }
}