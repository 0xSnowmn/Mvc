<?php

namespace Mvc;

use Mvc\Lib\Frontcontroller;
use Mvc\Lib\Language;
use Mvc\Lib\appSession;
use Mvc\Lib\Registry;
use Mvc\Lib\Messenger;
use Mvc\Lib\Template\Template;


include '../app/config/config.php';
include APP_PATH . 'lib/autoload.php';
$tpl_parts = include APP_PATH . 'config/tpl_config.php';
include APP_PATH . 'lib/Template/template.php';

$session = new appSession();
$session->start();
if(!isset($session->lang)) {
    $session->lang = DEFAULT_LANGUAGE;
}
$tpl = new Template($tpl_parts);
$messenger = Messenger::getInstance($session);
$language = new Language();
$registry = Registry::getInstance();
$registry->language = $language;
$registry->session = $session;
$registry->messenger = $messenger;
$front = new Frontcontroller($tpl,$registry);
$front->dispatch();







?>


