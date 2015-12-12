<?php
	/**
	 * Instancer creates one instance for class and use it as main
	 * To use instancer, just extend this class and use i() function
	 * For example: SomeClass::i()->func()
	 */
	
	namespace Fructum;
	
	class Instancer
	{
		protected static $i = null;
		
		/**
		 * Init or use class instance
		 *
		 * @return object
		 */
		public static function i()
		{
			if(self::$i == null)
			{
				$class = get_called_class();
				self::$i = new $class;
			}
			return self::$i;
		}
	}