<?php

namespace Mvc\Controllers;
use Mvc\Lib\Helper;
use Mvc\Models\UserModel;
use Mvc\Lib\InputFilter;


class UserController extends AbstractController {
    use InputFilter;
    use Helper;
    public function defaultAction() {
        var_dump($this);
    }
}