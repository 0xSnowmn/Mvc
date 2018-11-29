<?php

namespace Mvc\Controllers;
use Mvc\Lib\Helper;
use Mvc\Models\UserModel;
use Mvc\Lib\InputFilter;


class UsersGroupsController extends AbstractController {
    use InputFilter;
    use Helper;

    public function defaultAction() {
        
        $this->_language->load('users|create');
        $this->_view();
        
    }
    
    public function createAction() {
        
        $this->_language->load('users|create');
        $this->_view();
        
    }
}