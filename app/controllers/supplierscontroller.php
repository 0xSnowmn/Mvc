<?php
namespace Mvc\Controllers;

use Mvc\Lib\Helper;
use Mvc\Lib\InputFilter;
use Mvc\Lib\Messenger;
use Mvc\Models\SupplierModel;
use Mvc\Lib\Validate;

class SuppliersController extends AbstractController
{
    use Validate;
    use InputFilter;
    use Helper;

    private $_createActionRoles =
    [
        'Name'          => 'req|alpha|between(3,40)',
        'Email'         => 'req|email',
        'PhoneNumber'   => 'alphanum|max(15)',
        'Address'       => 'req|alphanum|max(50)'
    ];

    public function defaultAction()
    {
        $this->language->load('suppliers|default');

        $this->data['suppliers'] = SupplierModel::getAll();

        $this->_view();
    }

    public function createAction()
    {

        $this->language->load('suppliers|create');
        $this->language->load('suppliers|labels');
        $this->language->load('suppliers|messages');
        $this->language->load('validation|error');

        if(isset($_POST['submit']) && $this->valid($this->_createActionRoles, $_POST)) {

            $supplier = new SupplierModel();

            $supplier->Name = $this->filt_str($_POST['Name']);
            $supplier->Email = $this->filt_str($_POST['Email']);
            $supplier->PhoneNumber = $this->filt_str($_POST['PhoneNumber']);
            $supplier->Address = $this->filt_str($_POST['Address']);

            if($supplier->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), MESSAGE_ERROR);
            }
            $this->redirect('/suppliers');
        }

        $this->_view();
    }

    public function editAction()
    {

        $id = $this->filt_int($this->params[0]);
        $supplier = SupplierModel::getByPK($id);

        if($supplier === false) {
            $this->redirect('/suppliers');
        }

        $this->data['supplier'] = $supplier;

        $this->language->load('suppliers|edit');
        $this->language->load('suppliers|labels');
        $this->language->load('suppliers|messages');
        $this->language->load('validation|error');

        if(isset($_POST['submit']) && $this->valid($this->_createActionRoles, $_POST)) {

            $supplier->Name = $this->filt_str($_POST['Name']);
            $supplier->Email = $this->filt_str($_POST['Email']);
            $supplier->PhoneNumber = $this->filt_str($_POST['PhoneNumber']);
            $supplier->Address = $this->filt_str($_POST['Address']);

            if($supplier->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), MESSAGE_ERROR);
            }
            $this->redirect('/suppliers');
        }

        $this->_view();
    }

    public function deleteAction()
    {

        $id = $this->filt_int($this->params[0]);
        $supplier = SupplierModel::getByPK($id);

        if($supplier === false) {
            $this->redirect('/suppliers');
        }

        $this->language->load('suppliers|messages');

        if($supplier->delete()) {
            $this->messenger->add($this->language->get('message_delete_success'));
        } else {
            $this->messenger->add($this->language->get('message_delete_failed'), MESSAGE_ERROR);
        }
        $this->redirect('/suppliers');
    }
}