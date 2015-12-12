<?php
	/**
	 * Fructum error handlers
	 * 
	 * @version 1.0
	 * @author Mike Chip
	 */
	
	namespace Fructum;
	
	class Errors
	{
		
		/**
		 * Handler for all errors
		 *
		 * @param int $errno
		 * @param string $errstr
		 * @param string $errfile
		 * @param int $errline
		 * @param mixed $errcontext
		 */
		public static function error_handler($errno, $errstr, $errfile, $errline, $errcontext)
		{
			throw new Exception($errstr);
		}
		
		/**
		 * Handler for all uncaught exceptions
		 *
		 * $param object $e
		*/
		public static function exception_handler($e)
		{
			//die(nl2br($e->__toString()));
		}
		
	}