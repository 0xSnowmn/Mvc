<?php

namespace Mvc;


include '../app/config.php';
include APP_PATH . 'lib/autoload.php';

use Mvc\Lib\Frontcontroller;

$front = new Frontcontroller();
$front->dispatch();







?>


