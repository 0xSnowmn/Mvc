<?php

namespace Mvc\Controllers;

use Mvc\Lib\Validate;
use Mvc\Models\UserModel;


class TestController extends AbstractController {
    use Validate;
    public function defaultAction() {
        var_dump(UserModel::getBy(['Username' => 'yghonem2']));
    }
}