<?php

namespace Mvc;


include '../app/config/config.php';
include APP_PATH . 'lib/autoload.php';
$tpl_parts = include APP_PATH . 'config/tpl_config.php';
include APP_PATH . 'lib/template.php';

use Mvc\Lib\Frontcontroller;
use Mvc\Lib\Template;
use Mvc\Lib\Language;
use Mvc\Lib\appSession;
$session = new appSession();
$session->start();
if(!isset($session->lang)) {
    $session->lang = DEFAULT_LANGUAGE;
}
$tpl = new Template($tpl_parts);
$language = new Language();
$front = new Frontcontroller($tpl,$language);
$front->dispatch();







?>


