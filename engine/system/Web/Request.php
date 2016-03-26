<?php
	/**
	 * Class stores client request information
	 */
	 
	namespace Web;
	
	class Request extends \Fructum\Instancer
	{
		
		public $cookie = array();
		public $post = array();
		public $get = array();
		public $request = array();
		public $files = array();
		public $uri = null;
		public $domain = null;
		public $ip = null;
		public $request_time = 0;
		
		/**
		 * Auto-detect all request data of current client 
		 */
		public function autodetect()
		{
			$this->cookie = isset($_COOKIE) ? $_COOKIE : array();
			$this->post = isset($_POST) ? $_POST : array();
			$this->get = isset($_GET) ? $_GET : array();
			$this->request = isset($_REQUEST) ? $_REQUEST : array();
			$this->files = isset($_FILES) ? $_FILES : array();
			$this->uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
			$this->domain = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
			$this->ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
			$this->request_time = isset($_SERVER['REQUEST_TIME_FLOAT']) ? microtime()-$_SERVER['REQUEST_TIME_FLOAT'] : 0;
			
			$current_time = explode(' ', microtime());
			$current_time = is_array($current_time) ? $current_time[0]+$current_time[1] : $current_time;
			$this->request_time = $current_time - $_SERVER['REQUEST_TIME_FLOAT'];
		}
		
	}