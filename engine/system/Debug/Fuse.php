<?php
	
	/** 
	 * Fuse - official Fructum debugger
	 *
	 * @version 1.0
	 * @author Mike Chip
	 */
	 
	namespace Debug;
	
	class Fuse
	{
		/** 
		 * Array $data stores all Fuse Debugger's data
		 */
		private static $data = array();
		
		/**
		 * If true, asHTML() method returns empty string 
		 */
		public static $empty_html = false;
		
		/** 
		 * Returns all debug data as HTML (using debug.html template)
		 * @return string
		 */
		public static function asHTML()
		{
			if(self::$empty_html == true) {
				return '';
			}
			
			return (new \Templater\Native('debug'))->set('array', self::$data)->render();
		}
		
		/**
		 * Returns all debug data as array 
		 * @return array 
		 */
		public static function getData()
		{
			return is_array(self::$data) ? self::$data : array();
		}
		
		/**
		 * Sets variable 
		 *
		 * @param string $var
		 * @param mixed $val
		 * @return boolean
		 */
		public static function setData($var, $val)
		{
			self::$data[$var] = $val;
			return (self::$data[$var] === $val);
		}
		
		/**
		 * Appends data to array
		 *
		 * @param string $var
		 * @param mixed $val
		 * @return boolean
		 */
		public static function addData($var, $val)
		{
			if(is_array($val))
			{
				if(!isset(self::$data[$var]) or !is_array(self::$data[$var])) {
					self::$data[$var] = array();
				}
				self::$data[$var][] = $val;
				return true;
			}
			elseif(is_numeric($val) and (is_numeric(self::$data[$var]) or !isset(self::$data[$var])))
			{
				self::$data[$var] += $val;
				return true;
			}
			elseif(is_scalar($val))
			{
				self::setData($var, $val);
				return true;
			}
			else {
				throw new \Fructum\Exception('Cannot add debug data: bad type');
				return false;
			}
		}
		
	}