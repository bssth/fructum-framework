<?php
	/**
	 * Web application handler
	 * 
	 * @author Mike Chip
	 * @version 1.1
	 */
	
	namespace Application;
	
	class WebApp extends \Fructum\Instancer
	{
		protected $buffer = ''; // output buffer
		protected $cookie = array();
		protected $route = array();
		protected $headers = array();
		
		/**
		 * Gets all cookies, URL query, set controller and call it. 
		 * 
		 * Sends new cookies and headers to client, prints HTML from output buffer
		 *
		 * @return void
		 *
		 */
		public function init()
		{
			if(\Fructum\Config::debug !== true) {
				set_exception_handler( array($this, 'exception_handler') );
			}

			$this->cookie = isset($_COOKIE) ? $_COOKIE : array();
			$this->headers = array();
			$route = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
			$this->route = $this->router($route);
			
			$classname = "Controller\\" . ucfirst($this->route[1]);
			if(!class_exists($classname, true)) { return $this->error(404); }
			$class = new $classname;
			$method = "action" . ucfirst($this->route[2]);
			if(!method_exists($class, $method) and !method_exists($class, '__call')) { return $this->error(404); } 
			
			$this->output( call_user_func_array( array($class, $method), $this->route) );
			
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
		
		/**
		 * Sends header to client
		 *
		 * @param string $header
		 * @return void
		 */
		public function header($header)
		{
			$this->headers[$header] = $header;
		}
		
		/**
		 * Set cookie for client
		 * 
		 * @param string $name
		 * @param string $value
		 * @return bool
		 */
		public function set_cookie($name, $value)
		{
			$this->cookie[$name] = $value;
			return ($this->cookie[$name] == $value);
		}
		
		/**
		 * Get cookie by name 
		 *
		 * @param string $name
		 * @return mixed
		 */
		public function get_cookie($name)
		{
			return isset($this->cookie[$name]) ? $this->cookie[$name] : null;
		}
		
		/**
		 * Saves HTML to output buffer
		 *
		 * @return void
		 */
		public function output($data)
		{
			if(is_bool($data) and $data === false) { $this->buffer = ''; }
			if(!is_string($data)) { return; }
			$this->buffer = $this->buffer . $data;
		}
		
		/**
		 * Gets client's request string
		 * 
		 * @return array
		 */
		public function input()
		{
			return isset($_REQUEST) ? $_REQUEST : array();
		}
		
		/**
		 * Gets needed controller, action and other data from client
		 *
		 * @param string $route
		 * @return array
		 */
		public function router($route) 
		{
			if(strpos($route, '?') != false and strpos($route, '?') >= 0) { $route = trim(strstr($route, '?', true), '?'); }
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
		
		/**
		 * Web Exception Handler
		 */
		public function exception_handler($e)
		{
			$this->error(500);
		}
		
		/**
		 * Print error to user 
		 *
		 * @param int $code
		 * @return void
		 */
		public function error($code)
		{
			die( (new \Templater\Native($code))->render() );
		}
	}