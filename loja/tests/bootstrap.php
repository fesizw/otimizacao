<?php
/**
 * Bootstrap para testes PHPUnit
 */

// Autoload do Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Autoload de Models e Services
require_once __DIR__ . '/../autoload.php';

// Definir constantes necessárias
if (!defined('VIEWS_DIR')) {
    define('VIEWS_DIR', __DIR__ . '/../views/');
}
if (!defined('HELPER_DIR')) {
    define('HELPER_DIR', __DIR__ . '/../lib/Helper/');
}

// Mock do Zend_Registry para testes
class TestDbAdapter extends Zend_Db_Adapter_Pdo_Mysql
{
    public function __construct()
    {
        // Não conectar de verdade em testes unit
    }
}

// Configurar ambiente de teste
error_reporting(E_ALL);
ini_set('display_errors', 1);
