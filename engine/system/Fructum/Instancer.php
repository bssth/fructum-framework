<?php
	namespace Fructum;
	
	class Instancer
	{
		protected static $i = null;
		
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