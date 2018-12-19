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
        'Password'  => 'req|min(6)|eq_input(CPassword)',
        'CPassword' => 'req|min(6)',
        'Email'     => 'req|email|min(6)|eq_input(CEmail)',
        'CEmail'    => 'req|email|min(6)'
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
        $this->language->load('users|messages');
        $this->data['groups'] = UsersGroupsModel::getAll();

        if(isset($_POST['submit']) && $this->Valid($this->_createRoles,$_POST)) {
           $user = new UserModel();
           $user->Username = $this->filt_str($_POST['Username']);
           $user->Email = $this->filt_str($_POST['Email']);
           $user->Password =$user->cryptPass($_POST['Password']);
           $user->LastLogin = date('Y-m-d h:m:s');
           $user->GroupId = $this->filt_int($_POST['GroupId']);
           $user->SubscriptionDate = date('Y-m-d');
           $user->Status = 1;
           if($user->save()) {
            $this->messenger->add($this->language->get('message_create_success'),MESSAGE_SUCCESS);
           } else {
            $this->messenger->add($this->language->get('message_create_failed'),MESSAGE_ERROR);
           }
           $this->Redirect('users');
        }
        $this->_view();
        
    }

    public function editAction() {
        $user = UserModel::getByPK($this->filt_int($this->params[0]));
        $this->data['user'] = $user;

        $this->language->load('users|label');
        $this->language->load('users|edit');
        $this->_view();
        
    }

    public function checkUserAjaxAction() {
        if(isset($_POST['Username']) && $_POST['Username'] !== '') {
                $username = $this->filt_str($_POST['Username']);
                $user = UserModel::getBy(['Username' => $username ]);
                if($user == true) {
                    echo 0;
                } else {
                    echo 1;
                }
        }
    }
}