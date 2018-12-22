<?php

namespace Mvc\Lib;
use Mvc\Lib\Helper;
class Frontcontroller {
    use Helper;
    const NOT_FOUND_CONTROLLER  = 'Mvc\Controllers\NotfoundController';
    const NOT_FOUND_ACTION      = 'notFoundAction';

    private $_controller = 'index';
    private $_action     = 'default';
    private $params     = [];

    private $_tpl;
    private $_auth;
    private $_regisrty;

    public function __construct(Template\Template $Template,Registry $registry,Authentication $auth) {
        $this->_regisrty = $registry;
        $this->_tpl = $Template;
        $this->_auth = $auth;
        $this->Url();
    }
    private function Url() {
        $url = explode('/',trim(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH),'/'),3);
        if(isset($url[0]) && $url[0] != '') {
            $this->_controller = $url[0];
        }
        if(isset($url[1]) && $url[1] != '') {
            $this->_action = $url[1];
        }
        if(isset($url[2]) && $url[2] != '') {
            $this->params = explode('/',$url[2]); 
        }    
    }

    public function dispatch() {
        $className      = 'Mvc\Controllers\\' . ucfirst($this->_controller) . 'Controller';
        $actionName     = $this->_action . 'Action';
        if(!$this->_auth->isAuthorized()) {
            if($this->_controller != 'auth' && $this->_action != 'login') {
                $this->Redirect('/auth/login');
            }
        } else {
            if($this->_controller == 'auth' && $this->_action == 'login') {
                isset($_SERVER['HTTP_REFERER']) ? $this->Redirect($_SERVER['HTTP_REFERER']) : $this->Redirect();
            }
            if((bool)CHECK_ACCESS == false ) {
                if(!$this->_auth->hasAccess($this->_controller,$this->_action)) {
                    $this->Redirect('/accessdenied');
                }
            }
        }
        if(!class_exists($className) || !method_exists($className,$actionName)) {
            $className  = self::NOT_FOUND_CONTROLLER;
            $this->_action = $actionName = self::NOT_FOUND_ACTION;
        }
        $controller = new $className();
        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setParams($this->params);
        $controller->setTemplate($this->_tpl);
        $controller->setRegistry($this->_regisrty);
        $controller->$actionName();


        
       
        
    }
    
}