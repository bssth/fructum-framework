<?php
	/**
	 * Web application handler
	 * 
	 * @author Mike Chip
	 * @version 1.2
	 */
	
	namespace Application;
	
	class WebApp extends \Fructum\Instancer
	{
		/**
		 * Array with route data
		 */
		protected $route = array();
		
		/**
		 * Gets all cookies, URL query, set controller and call it. 
		 * Sends new cookies and headers to client, prints HTML from output buffer
		 *
		 * @return void
		 */
		public function init()
		{
			if(\Fructum\Config::debug !== true) {
				set_exception_handler( array($this, 'exception_handler') ); // reset exception handler (for valid HTTP errors printing)
			}
			
			\Web\Request::i()->autodetect();
			
			\Web\Response::$i = new \Web\Response;
			\Web\Response::$i->setCookie( isset($_COOKIE) ? $_COOKIE : array(), null ); // write cookies 
			
			$this->route = \Web\Router::getRoute( \Web\Request::i()->uri ); // launch router 
			
			$classname = \Web\Router::getClassName($this->route[1]); 
			
			if(!class_exists($classname, true)) { 
				\Templater\Native::exists('static_' . $this->route[1]) ? \Web\Response::$i->sendHTML((new \Templater\Native('static_' . $this->route[1]))->render()) : $this->error(404); 
			} // if controller is not found and there is no static page - close with 404 
			else {
				$class = new $classname; // else - create instance
				$method = "action" . ucfirst($this->route[2]); 
				if(!method_exists($class, $method) and !method_exists($class, '__call')) { return $this->error(404); } // if no handler - close with 404  
				
				\Web\Response::$i->sendHTML( call_user_func_array( array($class, $method), $this->route) ); // else print result of controller work (using return)
			}
			
			\Web\Response::$i->send();
		}
		
		/**
		 * Sends header to client
		 *
		 * @param string $header
		 * @return void
		 */
		public function header($header)
		{
			\Web\Response::$i->sendHeader($header);
		}
		
		/**
		 * Saves HTML to output buffer
		 *
		 * @return void
		 */
		public function output($data)
		{
			\Web\Response::$i->sendHTML($data);
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
			return \Web\Router::getRoute($route);
		}
		
		/**
		 * Web Exception Handler
		 * @param object $e
		 * @return void
		 */
		public function exception_handler($e)
		{
			$this->error(500); // if exception is thrown - print internal server error
		}
		
		/**
		 * Print error to user 
		 *
		 * @param integer $code
		 * @return void
		 */
		public function error($code)
		{
			\Fructum\EventListener::invoke('web_error', $code);
			die( (new \Templater\Native($code))->render() ); // find template for error with $code code and render it
		}
	}