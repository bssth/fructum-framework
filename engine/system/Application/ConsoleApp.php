<?php
	/**
	 * Application handler for command line project
	 * 
	 * @author Mike Chip
	 */
	
	namespace Application;
	
	class ConsoleApp extends \Fructum\Instancer implements _Interface
	{
		
		/**
		 * Run console controller from extensions
		 * @return void
		 */
		public function init()
		{
			if(class_exists('\Handler\Console'))
			{
				$a = new \Handler\Console;
				if(!method_exists($a, 'start'))
				{
					throw new Exception('No start() method in console handler found');
				}
				$a->start();
				\Fructum\EventListener::invoke('console_init');
			}
			else
			{
				throw new Exception('No console handler registered');
			}
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