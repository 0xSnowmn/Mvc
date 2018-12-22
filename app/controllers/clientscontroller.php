<?php
namespace Mvc\Controllers;

use Mvc\Lib\Helper;
use Mvc\Lib\InputFilter;
use Mvc\Lib\Messenger;
use Mvc\Models\ClientModel;
use Mvc\Lib\Validate;

class ClientsController extends AbstractController
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
        $this->language->load('clients|default');

        $this->data['clients'] = ClientModel::getAll();

        $this->_view();
    }

    public function createAction()
    {

        $this->language->load('clients|create');
        $this->language->load('clients|labels');
        $this->language->load('clients|messages');
        $this->language->load('validation|error');

        if(isset($_POST['submit']) && $this->valid($this->_createActionRoles, $_POST)) {

            $client = new ClientModel();

            $client->Name = $this->filt_str($_POST['Name']);
            $client->Email = $this->filt_str($_POST['Email']);
            $client->PhoneNumber = $this->filt_str($_POST['PhoneNumber']);
            $client->Address = $this->filt_str($_POST['Address']);

            if($client->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), MESSAGE_ERROR);
            }
            $this->Redirect('/clients');
        }

        $this->_view();
    }

    public function editAction()
    {

        $id = $this->filt_int($this->params[0]);
        $client = ClientModel::getByPK($id);

        if($client === false) {
            $this->Redirect('/clients');
        }

        $this->data['client'] = $client;

        $this->language->load('clients|edit');
        $this->language->load('clients|labels');
        $this->language->load('clients|messages');
        $this->language->load('validation|error');

        if(isset($_POST['submit']) && $this->valid($this->_createActionRoles, $_POST)) {

            $client->Name = $this->filt_str($_POST['Name']);
            $client->Email = $this->filt_str($_POST['Email']);
            $client->PhoneNumber = $this->filt_str($_POST['PhoneNumber']);
            $client->Address = $this->filt_str($_POST['Address']);

            if($client->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), MESSAGE_ERROR);
            }
            $this->Redirect('/clients');
        }

        $this->_view();
    }

    public function deleteAction()
    {

        $id = $this->filt_int($this->params[0]);
        $client = ClientModel::getByPK($id);

        if($client === false) {
            $this->Redirect('/clients');
        }

        $this->language->load('clients|messages');

        if($client->delete()) {
            $this->messenger->add($this->language->get('message_delete_success'));
        } else {
            $this->messenger->add($this->language->get('message_delete_failed'),MESSAGE_ERROR);
        }
        $this->Redirect('/clients');
    }
}