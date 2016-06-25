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
			try {
				\Fructum\EventListener::invoke('error', func_get_args()); // invoke event
			}
			catch(Exception $e) {
				throw new Exception("Cannot handle error: " . $e->__toString());
			}
			throw new Exception( "Error #{$errno}: {$errstr} [File {$errfile} in line {$errline}]" ); // throw exception
		}
		
		/**
		 * Handler for all uncaught exceptions
		 *
		 * $param object $e
		*/
		public static function exception_handler($e)
		{
			return true; // todo
		}
		
	}