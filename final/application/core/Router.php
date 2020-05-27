<?php
namespace application\core;

use application\lib\Db;


class Router
{
  protected $routes = [];
  protected $params = [];
  protected $main_url = '';
  protected $url_params = '';
  protected $post_vars = [];
  
  public function __construct()  {
    $rts = require 'application/config/routes.php';
//    dump(parse_url($_SERVER['REQUEST_URI'])['path']);

    foreach ($rts as $key => $value) {
      $this->add($key, $value);
//      dump($this->routes);
    }

  }

  public function add($route, $params) {
    $route = '#^'.$route.'$#';
    $this->routes[$route] = $params;
  }

  public function match() {

    $this->processUrl( $_SERVER['REQUEST_URI'] );
//      dump($this->routes);
    foreach ($this->routes as $route => $params) {


        if ( preg_match($route, $this->main_url, $matches) ) {
            $this->params = $params;
            return true;
        }
    }
      return false;
  }

  public function run() {
//      dump('sdfsdfsd');
    if ($this->match()) {
//        echo 'sdfsf';
      $path = 'application\controllers\\' . ucfirst( $this->params['controller']) . 'Controller';

      if ( class_exists($path) ) {
        $action = $this->params['action'];

        
        if (method_exists($path, $action)) {
//           dump($this->params);
          $controller = new $path( $this->params, $this->url_params, $this->post_vars );
          $controller->$action();

        }
        else {
          echo $action . ' not found! <br/>LINE: ' . __LINE__ . '<BR> METHOD: ' . __METHOD__;
        }
      }
      else {
        echo $path . ' not found! <br/>LINE: ' . __LINE__ . '<BR> METHOD: ' . __METHOD__;
      }

    } 
    else {
      // $view = new View();
      // $view->render('404', ['errors' => ['No such route defined']]);
      echo 'page not found';
    }
  }

  private function processUrl($url) {
    
    $s_url = trim( $url, "/" );
    $url = explode ( "/", $s_url );

    // выделяем два первых параметра из урла (по нашим правилам рутинга это контроллер и метод этого контроллера)



    // $main_url = array_slice($url, 0, 2);
    // $this->main_url = $this->sanitizeInput( implode('/', $main_url) );

    $main_url = parse_url($_SERVER['REQUEST_URI'])['path'];
     $main_url = trim( $main_url, "/" );


    $this->main_url = $main_url;




    // это все остальные параметры в урле - их может быть сколько угодно, весь их разбор остается за разработчиком внутри контроллеров
    // 
    $this->url_params = $this->sanitizeInput( array_slice($url, 2) );


    if ( !empty($_POST) ) {
      $this->post_vars = $this->sanitizeInput($_POST);
    }
      

  }

  private function sanitizeInput($str) {

    if ( is_array($str) ) {
      $res = [];
      foreach ($str as $k => $s) {
        $res[$k] = trim($s);
        $res[$k] = strip_tags($s);
        $res[$k] = htmlspecialchars($res[$k]);
      }
      return $res;
    }

    $input_text = trim($str);
    $input_text = strip_tags($input_text);
    $input_text = htmlspecialchars($input_text);

    return $input_text;
  }

}