<?php
	/**
	 * Exceptions special for applications.
	 * You can set exception code (http, for example) and name of application thrown.
	 */
	 
	namespace Application;
	 
	class Exception extends \Fructum\Exception
	{
	 
		public $ex_code = 0;
		public $called_by = 'unknown';
		
	}