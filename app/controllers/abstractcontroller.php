<?php

namespace Mvc\Controllers;

use Mvc\Lib\Frontcontroller;


class AbstractController {
    
    protected $_controller;
    protected $_action;
    protected $params;

    public function notFoundAction() {
        $this->_view();
    }

    public function setController($controller) {
        $this->_controller = $controller;
    }

    public function setAction($action) {
        $this->_action = $action;
    }

    public function setParams($param) {
        $this->params = $param;
    }
    
    protected function _view() {

        $view = VIEW_PATH . $this->_controller . '/' . $this->_action . '.v.php';
        if($this->_action == Frontcontroller::NOT_FOUND_ACTION) {
            $view = VIEW_PATH . 'notfound/notfound.v.php';
        }
        if(file_exists($view)) {
            require $view;
        } else {
            require VIEW_PATH . 'notfound/noview.v.php';
        }
    }
}