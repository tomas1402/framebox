<?php

/**
  * Front Controller
  * PHP Version 5.4
  */

//Require the controller class
//require '../App/Controllers/Posts.php';

/**
  * Autoloader
  */

spl_autoload_register(function ($class) {
  $root = dirname(__DIR__); //obtiene el directorio principal.
  $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
  if (is_readable($file)) {
    require $root . '/' . str_replace('\\', '/', $class) . '.php';
  }
});

/**
  * Routing
  */

$router = new Core\Router();

//Agregar las rutas.
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);
