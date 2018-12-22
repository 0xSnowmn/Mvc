<?php
namespace Mvc\Controllers;
class AccessDeniedController extends AbstractController {
    public function defaultAction() {
        $this->language->load('access|d');
        $this->_view();
    }
}