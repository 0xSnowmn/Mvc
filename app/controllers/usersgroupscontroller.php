<?php

namespace Mvc\Controllers;
use Mvc\Lib\Helper;
use Mvc\Models\UserModel;
use Mvc\Lib\InputFilter;
use Mvc\Models\UsersGroupsModel;
use Mvc\Models\PrivilegeModel;
use Mvc\Models\UsersGroupsPrivilegesModel;


class UsersGroupsController extends AbstractController {
    use InputFilter;
    use Helper;

    public function defaultAction() {
        $this->_language->load('usersgroups|labels');
        $this->_language->load('usersgroups|default');
        $this->data['groups'] = UsersGroupsModel::getAll();
        $this->_view();
        
    }
    
    public function createAction() {
        $this->_language->load('usersgroups|labels');
        $this->_language->load('usersgroups|create');
        $this->data['privileges'] = PrivilegeModel::getAll();
        if(isset($_POST['submit'])) {
            $group = new UsersGroupsModel;
            $group->GroupName = $this->filt_str($_POST['GroupName']);
            if($group->save()) {
                if(isset($_POST['privileges']) && is_array($_POST['privileges'])) {
                    foreach($_POST['privileges'] as $privilegeId) {
                        $groupPrivilege = new UsersGroupsPrivilegesModel;
                        $groupPrivilege->GroupId = $group->GroupId;
                        $groupPrivilege->PrivilegeId = $privilegeId;
                        $groupPrivilege->save();
                    }
                    $this->Redirect();
                }
            }
        }
        $this->_view();
        
    }

    public function editAction() {
        $id = $this->filt_int($this->params[0]);
        $group = UsersGroupsModel::getByPK($id);
        if($group == false) {
            $this->Redirect('/usersgroups');
        }
        
        
        $this->_language->load('usersgroups|labels');
        $this->_language->load('usersgroups|edit');
        $this->data['group'] = $group;
        $this->data['privileges'] = PrivilegeModel::getAll();
        $this->data['groupPrivileges'] = UsersGroupsPrivilegesModel::getBy(['GroupId' => $group->GroupId]);
      echo '<pre>';  print_r($this->data['groupPrivileges']);
        /*
        if(isset($_POST['submit'])) {
            $group = new UsersGroupsModel;
            $group->GroupName = $this->filt_str($_POST['GroupName']);
            if($group->save()) {
                if(isset($_POST['privileges']) && is_array($_POST['privileges'])) {
                    foreach($_POST['privileges'] as $privilegeId) {
                        $groupPrivilege = new UsersGroupsPrivilegesModel;
                        $groupPrivilege->GroupId = $group->GroupId;
                        $groupPrivilege->PrivilegeId = $privilegeId;
                        $groupPrivilege->save();
                    }
                }
            } 
        }
        */
        $this->_view();
        
    }
}