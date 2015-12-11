<?php
	namespace Application;
	
	class ConsoleApp extends \Fructum\Instancer
	{
	
		public function init()
		{
			$a = new \Handler\Console;
			$a->start();
		}
		
		public function output($data)
		{
			print($data);
		}
		
		public function input()
		{
			return (isset($_SERVER['argv']) ? $_SERVER['argv'] : array() );
		}
		
	}