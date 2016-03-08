<?php
	/**
	 * Template for application
	 *
	 * @author Mike Chip
	 * @version 0.8
	 * @todo become an interface
	 *
	 */
	
	
	namespace Application;
	
	class Application
	{
		
		/**
		 * Function calls when application is created
		 *
		 * @return void
		 */
		public function init()
		{
		}
		
		/**
		 * Send data to output (echo\write in file\send to client, etc.)
		 *
		 * @param string $data
		 * @return void
		 */
		public function output($data)
		{
			print($data);
		}
		
		/**
		 * Get input from client (GET\POST\command line arguments\cookie, commands, etc.)
		 *
		 * @return array
		 */
		public function input()
		{
			return array();
		}
		
	}