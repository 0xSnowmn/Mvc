<?php

namespace Mvc\Controllers;

class IndexController extends AbstractController {
    public function defaultAction() {
        var_dump($this->messanger);
        $this->language->load('index|default');
        $this->_view();
        

    }

    public function createAction() {
        $this->language->load('index|default');
        $this->_view();
    }
}