<?php
namespace Mvc\Controllers;

use Mvc\Lib\Helper;
use Mvc\Models\UserModel;
use Mvc\Lib\InputFilter;
use Mvc\Models\UsersGroupsModel;
use Mvc\Lib\Validate;
use Mvc\Models\UsersProfileModel;


class UsersController extends AbstractController {
    use InputFilter;
    use Helper;
    use Validate;

    private $_createRoles = [
        'FirstName' => 'req|alpha|min(6)',
        'LastName'  => 'req|alpha|min(6)',
        'Username'  => 'req|alphanum|between(6,12)',
        'Password'  => 'req|min(6)|eq_input(CPassword)',
        'CPassword' => 'req|min(6)',
        'Email'     => 'req|email|min(6)|eq_input(CEmail)',
        'CEmail'    => 'req|email|min(6)'
    ];
    private $_editRoles = [
        'PhoneNumber'  => 'alphanum|max(12)'
    ];

    public function defaultAction() {
        $this->data['users'] = UserModel::getUsers($this->session->u);

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

           if(UserModel::UserExists($this->filt_str($_POST['Username']))) {
            $this->messenger->add($this->language->get('message_user_exists'),MESSAGE_ERROR);
            $this->Redirect('/users');
           }
           if(UserModel::EmailExists($this->filt_str($_POST['Email']))) {
            $this->messenger->add($this->language->get('message_user_exists'),MESSAGE_ERROR);
            $this->Redirect('/users');
           }
           if($user->save()) {
               $userProfile = new UsersProfileModel();
               $userProfile->UserId = $user->UserId;
               $userProfile->FirstName = $this->filt_str($_POST['FirstName']);
               $userProfile->LastName = $this->filt_str($_POST['LastName']);
               $userProfile->save(false);
            $this->messenger->add($this->language->get('message_create_success'),MESSAGE_SUCCESS);
           } else {
            $this->messenger->add($this->language->get('message_create_failed'),MESSAGE_ERROR);
           }
           $this->Redirect('/users');
        }
        $this->_view();
        
    }

    public function editAction() {
        $id = $this->filt_int($this->params[0]);
        $user = UserModel::getByPK($id);
        $groups = UsersGroupsModel::getAll();
        $this->language->load('users|label');
        $this->language->load('users|edit');
        $this->language->load('validation|error');
        $this->language->load('users|messages');
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        if(false == $user || $this->session->u->UserId == $id) {
            $this->Redirect('/users');
        }

        if(isset($_POST['submit']) && $this->Valid($this->_editRoles,$_POST)) {
            $user->PhoneNumber = $this->filt_str($_POST['PhoneNumber']);
            $user->GroupId = $this->filt_int($_POST['GroupId']);
            //var_dump($user);
            if($user->save()) {
             $this->messenger->add($this->language->get('message_create_success'),MESSAGE_SUCCESS);
            } else {
             $this->messenger->add($this->language->get('message_create_failed'),MESSAGE_ERROR);
            }
            $this->Redirect('/users');
         }
        
        $this->_view();
        
    }
    public function deleteAction() {
        $id = $this->filt_int($this->params[0]);
        $user = UserModel::getByPK($id);
        $this->language->load('users|messages');
        if($user == false || $this->session->u->UserId == $id) {
            $this->Redirect();
        }
        if($user->delete()) {
            $this->messenger->add($this->language->get('message_delete_success'),MESSAGE_SUCCESS);
            $this->Redirect('/users');
           } else {
            $this->messenger->add($this->language->get('message_delete_failed'),MESSAGE_ERROR);
        }
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