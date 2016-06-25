<?php
	/**
	 * API application handler
	 * 
	 * @author Mike Chip
	 */
	
	namespace Application;
	use \Fructum\Config as Config;
	
	class ApiApp extends \Fructum\Instancer implements _Interface
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
			$this->route = \Web\Router::getRoute( \Web\Request::i()->uri ); // launch router 
			$classname = \Web\Router::getClassName($this->route[1]); 
			
			$this->header('Content-Type: application/json');
			if(class_exists($classname, true)) { 
				$class = new $classname; // else - create instance
				$method = "actionApi" . ucfirst($this->route[2]); 
				if(!method_exists($class, $method) and !method_exists($class, '__call')) { return $this->error(404); } // if no handler - close with 404  
				
				$this->output(  json_encode(call_user_func_array( array($class, $method), $this->route)) );
			}
			else {
				$this->error(404);
			}
		}
		
		/**
		 * Sends header to client
		 *
		 * @param string $header
		 * @return void
		 */
		public function header($header)
		{
			header($header);
		}
		
		/**
		 * Saves HTML to output buffer
		 *
		 * @return void
		 */
		public function output($data)
		{
			print($data);
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
			die( json_encode( array('error' => $code) ) );
		}
	}