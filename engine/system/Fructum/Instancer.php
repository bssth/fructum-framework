<?php
	/**
	 * Instancer creates one instance for class and use it as main
	 * To use instancer, just extend this class and use i() function
	 * For example: SomeClass::i()->func()
	 */
	
	namespace Fructum;
	
	class Instancer
	{
		protected static $i = array();
		
		/**
		 * Init or use class instance
		 *
		 * @return object
		 */
		public static function i()
		{
			$class = get_called_class();
			
			if(!isset(self::$i[$class]))
			{
				self::$i[$class] = new $class;
			}
			
			return self::$i[$class];
		}
	}