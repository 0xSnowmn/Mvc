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
        $this->language->load('usersgroups|labels');
        $this->language->load('usersgroups|default');
        $this->data['groups'] = UsersGroupsModel::getAll();
        $this->_view();
        
    }
    
    public function createAction() {
        $this->language->load('usersgroups|labels');
        $this->language->load('usersgroups|create');
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
        
        $this->language->load('usersgroups|labels');
        $this->language->load('usersgroups|edit');
        $this->data['group'] = $group;
        $this->data['privileges'] = PrivilegeModel::getAll();
        $groupPrivileges = UsersGroupsPrivilegesModel::getBy(['GroupId' => $group->GroupId]);
        
        $extractedPrivileges = [];
        if(false !== $groupPrivileges) {
            foreach($groupPrivileges as $privilege) {
                $extractedPrivileges[] = $privilege->PrivilegeId;
            }
        }
        $this->data['groupPrivileges'] = $extractedPrivileges;
      
        if(isset($_POST['submit'])) {

            $privilegesToBeDelete = array_diff($extractedPrivileges,$_POST['privileges']);
            $privilegesToBeAdd = array_diff($_POST['privileges'],$extractedPrivileges);

            foreach($privilegesToBeDelete as $deletePrivelege) {
                $unWantedPrivileges = UsersGroupsPrivilegesModel::getBy(['PrivilegeId' => $deletePrivelege,'GroupId' => $group->GroupId]);
                $unWantedPrivileges->current()->delete();
            }

            
                if(isset($_POST['privileges']) && is_array($_POST['privileges'])) {
                    foreach($privilegesToBeAdd as $privilege) {
                        $groupPrivilege = new UsersGroupsPrivilegesModel;
                        $groupPrivilege->GroupId = $group->GroupId;
                        $groupPrivilege->PrivilegeId = $privilege;
                        $groupPrivilege->save();
                    }
                    $this->Redirect();
                }
        }
        $this->_view();
        
    }

    public function deleteAction() {
        $id = $this->filt_int($this->params[0]);
        $group = UsersGroupsModel::getByPK($id);
        if($group == false) {
            $this->Redirect('/usersgroups');
        }
        $groupPrivileges = UsersGroupsPrivilegesModel::getBy(['GroupId' => $group->GroupId]);

        if(false !== $groupPrivileges) {
            foreach($groupPrivileges as $pr) {
                $pr->delete();
            }
        }

        if($group->delete()) {
            $this->Redirect('/usersgroups');
        }
    }

}