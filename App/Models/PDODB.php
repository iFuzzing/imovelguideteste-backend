<?php

namespace App\Models;

class PDODB{
    private static $instance;

    public static function getPDODB(){
        if(!isset(self::$instance)){
            self::$instance = new \PDO("mysql:host=localhost;dbname=imovelguidedb;charset=utf8;","root","");
        }

        return self::$instance;
    }
}
