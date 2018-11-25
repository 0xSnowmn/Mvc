<?php

namespace Mvc;


include '../app/config/config.php';
include APP_PATH . 'lib/autoload.php';
$tpl_parts = include APP_PATH . 'config/tpl_config.php';
include APP_PATH . 'lib/template.php';

use Mvc\Lib\Frontcontroller;
use Mvc\Lib\Template;

$tpl = new Template($tpl_parts);
$front = new Frontcontroller($tpl);
$front->dispatch();







?>


