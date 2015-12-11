<?php
	namespace Fructum;
	
	class Errors
	{
	
		public static function error_handler($errno, $errstr, $errfile, $errline, $errcontext)
		{
			throw new Exception($errstr);
		}
		
		public static function exception_handler($e)
		{
			die(nl2br($e->__toString()));
		}
		
	}