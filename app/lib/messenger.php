<?php

namespace Mvc\Lib;
class Messenger {
    
    private static $_instance;
    private $_session;
    private $_messages = [];


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

    public function add($msg,$type = MESSAGE_SUCCESS) {
        if(!$this->messageExists()) {
            $this->_session->messages = [];
        }
        $msgs = $this->_session->messages;
        $msgs[] = [$msg,$type];
        $this->_session->messages = $msgs;
    }

    private function messageExists() {
        return isset($this->_session->messages);
    }

    public function getMessages() {
        if($this->messageExists()) {
            $this->_messages = $this->_session->messages;
            unset($this->_session->messages);
            return $this->_messages;
        }
        return [];
    }
}