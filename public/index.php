<?php

namespace Mvc;

//$
//var_dump(explode('/',trim($url,'/'),3));
include '../app/config.php';
include APP_PATH . 'lib/autoload.php';

use Mvc\Lib\Frontcontroller;

$front = new Frontcontroller();
$front->dispatch();







?>


