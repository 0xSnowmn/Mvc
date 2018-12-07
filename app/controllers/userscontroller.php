<?php

namespace Mvc\Controllers;
use Mvc\Lib\Helper;
use Mvc\Models\UserModel;
use Mvc\Lib\InputFilter;


class UsersController extends AbstractController {
    use InputFilter;
    use Helper;

    public function defaultAction() {
        $this->data['users'] = UserModel::getAll();

        $this->language->load('users|label');
        $this->language->load('users|default');
        $this->_view();
        
    }
    
    public function createAction() {

        $this->language->load('users|label');
        $this->language->load('users|create');
        $this->_view();
        
    }
}