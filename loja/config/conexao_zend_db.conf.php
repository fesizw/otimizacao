<?php
require_once "Zend/Loader.php";

# Requisição de classes via zend
Zend_Loader::loadClass('Zend_Registry');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Config_Ini');

$arqIni = $_SERVER['DOCUMENT_ROOT'] . "/config/config_db_interno.ini";
$_SESSION['debug'] = true;

$objDb = new Zend_Config_Ini($arqIni, 'general');
# Model - Zend
$objModel = Zend_Db::factory($objDb->db->adapter, $objDb->db->config->toArray());

// Garantir charset UTF-8 na conexão
$objModel->query("SET NAMES utf8mb4");
$objModel->query("SET CHARACTER SET utf8mb4");

Zend_Db_Table::setDefaultAdapter($objModel);
Zend_Registry::set('db', $objModel);
