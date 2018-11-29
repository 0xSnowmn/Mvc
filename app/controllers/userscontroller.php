<?php

namespace Mvc\Controllers;
use Mvc\Lib\Helper;
use Mvc\Models\UserModel;
use Mvc\Lib\InputFilter;


class UsersController extends AbstractController {
    use InputFilter;
    use Helper;
    
    public function createAction() {
        
        $this->_language->load('users|create');
        $this->_view();
        
    }
}