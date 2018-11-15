<?php
namespace Mvc\Lib;

class Autoload {
    public static function autoLoad($class) {
        $class = str_replace('Mvc','',$class);
        $class = str_replace('\\','/',$class);
        $class = strtolower($class);
        $class = $class . '.php';
        if(file_exists( APP_PATH . $class)) {
            require_once APP_PATH . $class;
        }
    }
}


spl_autoload_register(__NAMESPACE__ . '\Autoload::autoLoad');