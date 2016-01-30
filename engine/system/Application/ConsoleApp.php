<?php
	/**
	 * Application handler for command line project
	 */
	
	namespace Application;
	
	class ConsoleApp extends \Fructum\Instancer
	{
		
		/**
		 * Run console controller from extensions
		 * @return void
		 */
		public function init()
		{
			$a = new \Handler\Console;
			$a->start();
			\Fructum\EventListener::invoke('console_init');
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