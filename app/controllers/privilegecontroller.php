<?php

namespace Mvc\Controllers;
use Mvc\Lib\Helper;
use Mvc\Lib\InputFilter;
use Mvc\Models\PrivilegeModel;



class PrivilegeController extends AbstractController {
    use InputFilter;
    use Helper;
    
    public function defaultAction() {
        
        $this->_language->load('privilege|label');
        $this->_language->load('privilege|default');
        $this->data['privileges'] = PrivilegeModel::getAll();
        $this->_view();
        
    }
    public function createAction() {
        
        $this->_language->load('privilege|label');
        $this->_language->load('privilege|create');
        
        if(isset($_POST['submit'])) {
            $privilege = new PrivilegeModel();
            $privilege->PrivilegeTitle = $this->filt_str($_POST['PrivilegeTitle']);
            $privilege->Privilege = $this->filt_str($_POST['Privilege']);
            if($privilege->save()) {
                $this->Redirect('/');
            }
        }
        $this->_view();
    }

    public function editAction() {
        $id = $this->filt_int($this->params[0]);
        $privilege = PrivilegeModel::getByPK($id);

        if($privilege == false) {
            $this->Redirect();
        }

        $this->data['privilege'] = $privilege;


        $this->_language->load('privilege|label');
        $this->_language->load('privilege|edit');
        
        if(isset($_POST['submit'])) {
            $privilege->PrivilegeTitle = $this->filt_str($_POST['PrivilegeTitle']);
            $privilege->Privilege = $this->filt_str($_POST['Privilege']);
            if($privilege->save()) {
                $this->Redirect('/');
            }
        }
        
        $this->_view();
    }

    public function deleteAction() {
        $id = $this->filt_int($this->params[0]);
        $privilege = PrivilegeModel::getByPK($id);

        if($privilege == false) {
            $this->Redirect();
        }

        $this->data['privilege'] = $privilege;
            if($privilege->delete()) {
                $this->Redirect('/');
            }
        

    }
}