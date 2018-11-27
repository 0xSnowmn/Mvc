<?php

namespace Mvc\Controllers;

use Mvc\Lib\Frontcontroller;


class AbstractController {
    
    protected $_controller;
    protected $_action;
    protected $params;
    protected $data = [];
    protected $_tpl;
    protected $_language;

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

    public function setTemplate($template) {
        $this->_tpl = $template;
    }

    public function setLanguage($language) {
        $this->_language = $language;
    }

    public function setData($dat) {
        $this->data = $dat;
    }
    
    protected function _view() {

        $view = VIEW_PATH . $this->_controller . '/' . $this->_action . '.v.php';
        if($this->_action == Frontcontroller::NOT_FOUND_ACTION || !file_exists($view)) {
            $view = VIEW_PATH . 'notfound/noview.v.php';
        }
        $this->data = array_merge($this->data,$this->_language->getDictionary());
        $this->_tpl->setView($view);
        $this->_tpl->setData($this->data);
        $this->_tpl->render();
    }
}