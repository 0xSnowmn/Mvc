<?php

namespace Mvc\Lib;
class Messanger {
    
    private static $_instance;
    private $_session;
    private function __construct($session) {
        $this->_session = $session;
    }
    private function __clone() {}
    public static function getInstance(appSession $session) {
        if(self::$_instance === null) {
            self::$_instance = new self($session);
        }
        return self::$_instance;
    }
}