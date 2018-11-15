<?php

namespace Mvc\Controllers;

class AbstractController {
    public function notFoundAction() {
        echo 'Sorry This Page Doesn\'t Exists ';
    }
}