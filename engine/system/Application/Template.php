<?php
	/**
	 * Template for application
	 *
	 * @author Mike Chip
	 * @version 1.1
	 *
	 */
	
	
	namespace Application;
	
	interface Template
	{
		
		/**
		 * Function calls when application is created
		 *
		 * @return void
		 */
		public function init();
		
		/**
		 * Send data to output (echo\write in file\send to client, etc.)
		 *
		 * @param string $data
		 * @return void
		 */
		public function output($data);
		
		/**
		 * Get input from client (GET\POST\command line arguments\cookie, commands, etc.)
		 *
		 * @return array
		 */
		public function input();
		
	}