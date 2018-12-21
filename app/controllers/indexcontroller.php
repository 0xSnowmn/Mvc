<?php

namespace Mvc\Controllers;

use Mvc\Models\UsersGroupsPrivilegesModel;


class IndexController extends AbstractController {
    public function defaultAction() {
        $this->language->load('index|default');
        var_dump($this->session->u);
        var_dump(UsersGroupsPrivilegesModel::getBy(['GroupId' => $this->session->u->GroupId]));

        $this->_view();

        

    }

    public function createAction() {
        $this->language->load('index|default');
        $this->_view();
    }
}