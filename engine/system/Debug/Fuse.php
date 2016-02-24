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
		
		private static $data = array();
		
		public static function asHTML()
		{
			return (new \Templater\Native('debug'))->set('array', self::$data)->render();
		}
		
		public static function getData()
		{
			return is_array(self::$data) ? self::$data : array();
		}
		
		public static function setData($var, $val)
		{
			self::$data[$var] = $val;
			return (self::$data[$var] === $val);
		}
		
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