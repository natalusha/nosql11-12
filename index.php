<?php
namespace application\core;
// require 'application/lib/Dev.php';
require_once 'application\config\config.php';

use application\core\Router;


spl_autoload_register(function ($class) {

    $path = str_replace("\\", "/", $class) . '.php';
//    dump($path);
    if (file_exists($path)) {
    	require $path;
    }
});


session_start();

$router = new Router;
$router->run();

