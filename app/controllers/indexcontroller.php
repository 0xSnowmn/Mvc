<?php

namespace Mvc\Controllers;

class IndexController extends AbstractController {
    public function defaultAction() {
        $this->_view();
    }
}