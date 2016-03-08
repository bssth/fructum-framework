<?php
	/**
	 * Instancer creates one instance for class and use it as main
	 * To use instancer, just extend this class and use i() function
	 * For example: SomeClass::i()->func()
	 */
	
	namespace Fructum;
	
	class Instancer
	{
	
		protected static $i = array(); // because of issue, all instancer instances are stored in original static class
		
		/**
		 * Init or use class instance
		 *
		 * @return object
		 */
		public static function i()
		{
			$class = get_called_class(); // get class that extends instancer
			
			if(!isset(self::$i[$class]))
			{
				\Fructum\EventListener::invoke('new_instance', $class); // invoke event 
				self::$i[$class] = new $class; // add instance
			}
			
			return self::$i[$class]; // ..and just return instance
		}
		
		/**
		 * Uses static class as instance
		 */
		public static function __callStatic($method, $params)
		{
			return call_user_func_array(array(self::i(), $method), $params); // you can use Class::func instead of Class::i()->func
		}
	}