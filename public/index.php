<?php

/**
  * Front Controller
  * PHP Version 5.4
  */

/**
  * Routing
  */

require '../Core/Router.php';

$router = new Router();

//Agregar las rutas.
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);

//Mostrar la tabla de ruteo.
//echo '<pre>';
//var_dump($router->getRoutes());
//echo '</pre>';

//Comparar la ruta requerida.
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
  echo '<pre>';
  var_dump($router->getParams());
  echo '</pre>';
} else {
  echo "No route found for URL '$url'";
}
