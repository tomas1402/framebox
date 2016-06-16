<?php

namespace Core;

/**
  * Router
  *
  * PHP Version 5.4
  */

class Router
{

  /**
    * Array asociativo de rutas, contiene las rutas.
    */
    protected $routes = [];

  /**
    * Agrega una ruta a la tabla de ruteo.
    */
    public function add($route, $params = [])
    {
      // Convierte la ruta a una expressión regular: escapa las contrabarras.
      $route = preg_replace('/\//', '\\/', $route);

      //Convierte variables.
      $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

      //Convierte variables con expresiones regulares personalizadas.
      $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
      //Agregar inicio y fin de delimitadores, y el flag cae sensitive.
      $route = '/^' . $route . '$/i';

      $this->routes[$route] = $params;
    }

  /**
    * Obtiene todas las rutas de la tabla de ruteo.
    */
    public function getRoutes()
    {
      return $this->routes;
    }

  /**
    * Compara la ruta con la que está en la tabla de ruteo, seteando
    * los parametros correspondientes si se encuentra una ruta.
    */
    public function match($url)
    {
      foreach ($this->routes as $route => $params) {
        if (preg_match($route, $url, $matches)) {
          //Obtiene los grupos de valores.
          foreach ($matches as $key => $match) {
            if (is_string($key)) {
              $params[$key] = $match;
            }
          }
          $this->params = $params;
          return true;
        }
      }
      return false;
    }

  /**
    * Obtiene el parametro comparado recientemente.
    */
    public function getParams()
    {
      return $this->params;
    }

  /**
    * Convert the string with hyphens to StudlyCaps.
    * e. g. post-authors => PostAuthors
    */

    protected function convertToStudlyCaps($string)
    {
      return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    protected function convertToCamelCase($string)
    {
      return lcfirst($this->convertToStudlyCaps($string));
    }

    public function dispatch($url)
    {
      $url = $this->removeQueryStringVariables($url);

      if ($this->match($url)) {
        $controller = $this->params['controller'];
        $controller = $this->convertToStudlyCaps($controller);
        $controller = "App\Controllers\\$controller";

        if (class_exists($controller)) {
          $controller_object = new $controller();

          $action = $this->params['action'];
          $action = $this->convertToCamelCase($action);

          if (is_callable([$controller_object, $action])) {
            $controller_object->$action();
          } else {
            echo "Method $action (in controller $controller) not found";
          }
        } else {
          echo "Controller class $controller not found";
        }
      } else {
        echo "No route matched";
      }
    }

    protected function removeQueryStringVariables($url)
    {
      if ($url != '') {
        $parts = explode('&', $url, 2);

        if (strpos($parts[0], '=') === false) {
          $url = $parts[0];
        } else {
          $url = '';
        }
      }
    }
  }
