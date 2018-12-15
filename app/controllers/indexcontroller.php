<?php

namespace Mvc\Controllers;

class IndexController extends AbstractController {
    public function defaultAction() {
        $this->language->load('index|default');
        $this->_view();
        

    }

    public function createAction() {
        $this->language->load('index|default');
        $this->_view();
    }
}