<?php

namespace Mvc\Controllers;

use Mvc\Lib\Validate;
use Mvc\Models\UserModel;


class TestController extends AbstractController {
    use Validate;
    public function defaultAction() {
        echo MAX_SIZE_UPLOAD;
    }
}