<?php
	namespace Application;
	
	class WebApp extends \Fructum\Instancer
	{
		protected $buffer = '';
		protected $cookie = array();
		protected $route = array();
		protected $headers = array();
		
		public function init()
		{
			$this->cookie = isset($_COOKIE) ? $_COOKIE : array();
			$this->headers = array();
			$route = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
			$this->route = $this->router($route);
			
			$classname = "Controller\\" . $this->route[1];
			if(!class_exists($classname, true)) { return $this->error(404); }
			$class = new $classname;
			$method = "action_" . $this->route[1];
			if(!method_exists($class, $method)) { return $this->error(404); } 
			
			$this->output( call_user_method_array($method, $class, $route) );
			
			foreach($this->cookie as $k => $v)
			{
				setcookie($k, $v);
			}
			foreach($this->headers as $k => $v)
			{
				header($v);
			}
			
			print($this->buffer);
		}
		
		public function header($h)
		{
			$this->headers[$h] = $h;
		}
		
		public function set_cookie($name, $value)
		{
			$this->cookie[$name] = $value;
			return ($this->cookie[$name] == $value);
		}
		
		public function get_cookie($name)
		{
			return isset($this->cookie[$name]) ? $this->cookie[$name] : null;
		}
		
		public function output($data)
		{
			if(is_bool($data) and $data === false) { $this->buffer = ''; }
			if(!is_string($data)) { return; }
			$this->buffer = $this->buffer . $data;
		}
		
		public function input()
		{
			return isset($_REQUEST) ? $_REQUEST : array();
		}
		
		public function router($route) 
		{
			$urlArray = @explode("/", $route);
			if (empty($urlArray[1])) 
			{
				$urlArray[1] = "index";
			}
			if (empty($urlArray[2])) 
			{
				$urlArray[2] = "index";
			} 
			if (empty($urlArray)) 
			{
				$urlArray = array(false, 'index', 'index');
			}
			return $urlArray;
		}
		
		public function error($code)
		{
			echo $code;
		}
	}