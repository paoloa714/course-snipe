<?php

class Utils {

    public static function getConfig($config='config'){
        $path = self::getConfigDir().'/'.$config.'.php';
        $configArray = require($path);
        return $configArray;
    }
    
    public static function getBaseDir(){
        return dirname(dirname(dirname(__DIR__)));
    }
    
    public static function getConfigDir(){
        return self::getBaseDir().'/lib/configs';
    }

}
