<?php
spl_autoload_register(function ($className) {
    $basePath = dirname(__FILE__);
    
    if (strpos($className, 'Model_') === 0) {
        $file = $basePath . '/models/' . substr($className, 6) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }

    if (strpos($className, 'Service_') === 0) {
        $file = $basePath . '/services/' . substr($className, 8) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }

    return false;
});
