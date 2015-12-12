<?php
	/**
	 *	Console application example
	 *	
	 *	@author Mike Chip
	 *	@version 1.0
	 *
	*/
	
	
	namespace Handler;
	
	class Console
	{
		public function start()
		{
			$app = \Application\ConsoleApp::i(); // creating console app instance
			$app->output('Hello! Fructum Console works. Input is: 
			'); // echo text
			foreach($app->input() as $k => $v) // get all command line arguments
			{
				$app->output("{$k} -> {$v}
				"); // show them
			}
		}
	}