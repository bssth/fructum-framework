<?php
	/**
	 * Application handler for command line project
	 * 
	 * @author Mike Chip
	 */
	
	namespace Application;
	use \Fructum\Config as Config;
	
	class WebsocketApp extends \Fructum\Instancer implements _Interface
	{
		
		/**
		 * Run console Websocket from extensions
		 * @return void
		 */
		public function init()
		{
			set_exception_handler( array($this, 'exception_handler') );
			
			$s = new \Daemon\Websocket(Config::websocket_protocol, Config::websocket_host, Config::websocket_port);
			
			if(class_exists('\Handler\Websocket'))
			{
				$a = new \Handler\Websocket;
				if(!method_exists($a, 'start'))
				{
					throw new Exception('No start() method in websocket handler found');
				}
				
				$a->start($s);
			}
			
			$s->runServer();
			\Fructum\EventListener::invoke('ws_init');
		}
		
		/**
		 * Exception handler
		 */
		public function exception_handler($e)
		{
			$this->output($e->__toString());
			die;
		}
		
		/**
		 * Send text to console
		 *
		 * @param string $data
		 * @return void
		 */
		public function output($data)
		{
			print($data);
		}
		
		/**
		 * Get command line arguments
		 *
		 * @return array
		 */
		public function input()
		{
			return (isset($_SERVER['argv']) ? $_SERVER['argv'] : array() );
		}
		
	}