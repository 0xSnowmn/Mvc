<?php
namespace Mvc\Lib\Config;
// Directories
defined('APP_PATH') ? NULL :                define('APP_PATH',__DIR__ . '/../');
defined('VIEW_PATH') ? NULL :               define('VIEW_PATH', APP_PATH . 'views/');
defined('TEMPLATE_PATH') ? NULL :           define('TEMPLATE_PATH', APP_PATH . 'tpl/');
defined('LANGUAGE_PATH') ? NULL :           define('LANGUAGE_PATH', APP_PATH . 'languages/');
defined('DEFAULT_LANGUAGE') ? NULL :        define('DEFAULT_LANGUAGE','en');
defined('CSS') ? NULL :                     define('CSS', '/css/');
defined('JS') ? NULL :                      define('JS', '/js/');
// Session
defined('SESSION_SAVE_PATH') ? NULL :        define('SESSION_SAVE_PATH',APP_PATH . '../sessions');
// Database Credentials
defined('DATABASE_HOST_NAME')       ? null : define ('DATABASE_HOST_NAME', 'localhost');
defined('DATABASE_USER_NAME')       ? null : define ('DATABASE_USER_NAME', 'youssef');
defined('DATABASE_PASSWORD')        ? null : define ('DATABASE_PASSWORD', 'rebo');
defined('DATABASE_DB_NAME')         ? null : define ('DATABASE_DB_NAME', 'storedb');
defined('DATABASE_PORT_NUMBER')     ? null : define ('DATABASE_PORT_NUMBER', 3306);
defined('DATABASE_CONN_DRIVER')     ? null : define ('DATABASE_CONN_DRIVER', 1);