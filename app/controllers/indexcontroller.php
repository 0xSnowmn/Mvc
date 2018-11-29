<?php

namespace Mvc\Controllers;

class IndexController extends AbstractController {
    public function defaultAction() {
        
        $this->_language->load('index|default');
        $this->_view();

    }

    public function createAction() {
        $this->_language->load('index|default');
        $this->_view();
    }
}