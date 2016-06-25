<?php
	/**
	 * Debugger interface
	 */
	 
	namespace Debug;
	
	interface _Interface
	{
		
		/**
		 * Returns HTML code of debugger information
		 */
		public static function asHTML();
		
		/**
		 * Returns debugger information as text
		 */
		public static function asText();
		
		/**
		 * Returns all debugger data as array
		 */
		public static function getData();
		
		/**
		 * Sets variable in debugger data 
		 */
		public static function setData($var, $val);
		
		/**
		 * Appends variable to debugger data. If $var is array - adds these arrays to variable, numeric - adds old to new, else - just set new value
		 */
		public static function addData($var, $val);
		
	}