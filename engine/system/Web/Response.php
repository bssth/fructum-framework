<?php
	/**
	 * Response class 
	 */
	 
	namespace Web;
	
	class Response
	{
		public static $i = null; 
		
		protected $cookie = array();	
		protected $buffer = ''; // output buffer
		protected $headers = array();
		
		/**
		 * Saves HTML in buffer
		 * @param string $html 
		 * @return void
		 */
		public function sendHTML($html)
		{
			$this->buffer .= $html;
		}
		
		/**
		 * Saves header
		 * @param string $content 
		 * @return void
		 */
		public function sendHeader($content)
		{
			\Fructum\EventListener::invoke('header_added', $header);
			$this->headers[$content] = $content;
		}
		
		/**
		 * Saves cookie 
		 * @param string|array $var 
		 * @param string|null $val
		 * @return boolean
		 */
		public function setCookie($var, $val)
		{
			if(is_array($var))
			{
				$this->cookie = array_merge($this->cookie, $var);
				return true;
			}
			
			$this->cookie[$var] = is_string($val) ? $val : null;
			return true;
		}
		
		/**
		 * Sends all cookies, headers and buffer data
		 * @return void
		 */
		public function send()
		{
			foreach($this->cookie as $k => $v)
			{
				setcookie($k, $v); // set all cookies
			}
			foreach($this->headers as $k => $v)
			{
				header($v); // send all headers
			}
			
			print($this->buffer); // print all in buffer
		}
	}