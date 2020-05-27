<?php
namespace application\core;

class View
{
	public $path;
	public $layout = 'default';
	public $route;
	
	public function __construct($route = []) {
		if (empty($route)) {
			return false;
		}

		$this->route = $route;
		$this->path = $route['controller'].'/'.$route['action'];
//		dump($this->path);
	}

	public function render($title = '', $vars = []) {
	
		$template = 'application/views/' . $this->path . '.php';
		$layout = 'application/views/layouts/' . $this->layout . '.php';
		ob_start();

		if ( !empty($vars['errors']) ) {
			require 'application/views/errors.php';
		}

		if ( file_exists($template) ) {
			require $template;
		} 
		else {
			require 'application/views/404.php';
		}
		$content = ob_get_clean();

		require $layout;
	}


}