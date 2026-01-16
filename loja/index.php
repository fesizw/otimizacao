<?php
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL && ~E_NOTICE);
ini_set('display_startup_errors', 0);
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", "./erros-php.log");
define('DEV', true);

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/constantes.conf.php");

umask(0);

require_once './vendor/autoload.php';

try {
    Zend_Session::start(['gc_maxlifetime' => 86400, 'cookie_lifetime' => 86400]);
} catch (Exception $e) {}

require_once("config/conexao_zend_db.conf.php");

Zend_Registry::set('loja', Zend_Registry::get('db')->fetchRow('SELECT * FROM lojas WHERE id_lojas = 1', [], Zend_Db::FETCH_OBJ));

Zend_Loader::loadClass('Zend_Controller_Front');
Zend_Loader::loadClass('Zend_Filter_Input');

$objView = new Zend_View;
Zend_Registry::set('objView', $objView);

$objControl = Zend_Controller_Front::getInstance();
$objControl->returnResponse(true);
$objControl->setParam('useModules', true);
$objControl->setControllerDirectory(array(
    'default' => "./controllers/",
));

$objControl->setParam('useDefaultControllerAlways', true);
$objControl->throwExceptions(true);
$objControl->setParam('noViewRenderer', true);

$response = $objControl->dispatch();
$response->sendHeaders();
$response->outputBody();
