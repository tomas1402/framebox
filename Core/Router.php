<?php

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
  public function add($route, $params)
  {
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
      /*
      foreach ($this->routes as $route => $params) {
        if ($url == $route) {
          $this->params = $params;
          return true;
        }
      }
      */

      //Compara con el formato de la URL.
      $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";

      if (preg_match($reg_exp, $url, $matches)) {
        //Obtiene el grupo de valores.
        $params = [];

        foreach ($matches as $key => $match) {
          if (is_string($key)) {
            $params[$key] = $match;
          }
        }

        $this->params = $params;
        return true;
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
}
