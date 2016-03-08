<?php
	/**
	 * Cache class provides bridge between Memcache(d) and Fructum. If you want to use own cache, just create extension or hook with same named class and methods names
	 * 
	 * @author Mike Chip
	 * @version 1.0
	 */
	 
	namespace Database;
	 
	class Cache
	{
		/**
		 * Cache can't extend fructum instancer, so it has it's own
		 */
		protected static $i = null;
		
		/**
		 * This configurates cache
		 */
		public static $config = null;
		
		/**
		 * Class for cacheing
		 */
		public static $driver = null;
		
		/**
		 * Connects to cache server and/or returns instance of this class
		 */
		public static function i()
		{
			self::$driver = \Fructum\Config::cache;
			
			if(!is_object(self::$i))
			{
				$config = is_array(self::$config) ? self::$config : array(\Fructum\Config::cache_host, \Fructum\Config::cache_port, \Fructum\Config::cache_timeout);
				$class = self::$driver;
				self::$i = new $class;
				self::connect($config);
			}
			return self::$i;
		}
		
		/**
		 * Uses static class as instance
		 */
		public static function __callStatic($method, $params)
		{
			return call_user_func_array(array(self::i(), $method), $params);
		}
		
		/**
		 * Creates connection to cache. You need to give config array as argument in same order as arguments in memcache (or either) class
		 *
		 * @param array $config
		 */
		protected static function connect($config)
		{	
			$result = call_user_func_array(array(self::$i, 'connect'), $config);
			if($result == true)
			{
				return true;
			}
			else
			{
				throw new \Fructum\Exception('Error while connecting to cache server');
			}
		}
	}