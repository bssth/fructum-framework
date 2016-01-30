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
			\Fructum\EventListener::invoke('error', func_get_args());
			throw new Exception( "Error #{$errno}: {$errstr} [File {$errfile} in line {$errline}]" );
		}
		
		/**
		 * Handler for all uncaught exceptions
		 *
		 * $param object $e
		*/
		public static function exception_handler($e)
		{
			if(Config::debug === true) {
				die(nl2br($e->__toString()));
			}
		}
		
	}