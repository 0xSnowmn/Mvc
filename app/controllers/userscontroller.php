<?php

namespace Mvc\Controllers;
use Mvc\Lib\Helper;
use Mvc\Models\UserModel;
use Mvc\Lib\InputFilter;
use Mvc\Models\UsersGroupsModel;
use Mvc\Lib\Validate;


class UsersController extends AbstractController {
    use InputFilter;
    use Helper;
    use Validate;

    private $_createRoles = [
        'Username'  => 'req|alphanum|between(6,12)',
        'Password'  => 'req|alphanum|between(6,12)',
        'CPassword' => 'req|alphanum|between(6,12)',
    ];

    public function defaultAction() {
        $this->data['users'] = UserModel::getAll();

        $this->language->load('users|label');
        $this->language->load('users|default');
        $this->_view();
        
    }
    
    public function createAction() {

        $this->language->load('users|label');
        $this->language->load('users|create');
        $this->language->load('validation|error');
        $this->data['groups'] = UsersGroupsModel::getAll();

        if(isset($_POST['submit'])) {
           var_dump( $this->Valid($this->_createRoles,$_POST));
        }
        $this->_view();
        
    }
}