<?php

namespace Mvc\Controllers;

use Mvc\Lib\InputFilter;
use Mvc\Lib\Helper;
use Mvc\Models\UserModel;


class AuthController extends AbstractController {
    use InputFilter;
    use Helper;
    public function loginAction() {
        $this->_tpl->EditParts([':view' => ':vie']);
        $this->language->load('auth|login');
        if(isset($_POST['login'])) {
            $username = $this->filt_str($_POST['ucname']);
            $pass = $this->filt_str($_POST['ucpwd']);

            $found = UserModel::auth($username,$pass,$this->session);

            if($found == 1) {
                $this->Redirect();
            } elseif($found == 2) {
                $this->messenger->add($this->language->get('text_user_disabled'),MESSAGE_ERROR);
            } else {
                $this->messenger->add($this->language->get('text_user_not_found'),MESSAGE_ERROR);
            }

        }
        $this->_view();
    }

    public function logoutAction() {
        $this->session->kill();
        $this->Redirect();
    }
}