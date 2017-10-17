<?php
	/**
	 * DBManager provides support of all database types by one project
	 */
	
	namespace Database;
	use \Fructum\Config as Config;
	
	class DBM
	{
		
		protected static $instance;
		
		/**
		 * Get instance of driver
		 */
		public static function i() 
		{
			if(!is_object(self::$instance)) {
				$classname = "\\Database\\DBM\\" . Config::db_type;
				self::$instance = new $classname;
				if(!(self::$instance instanceof \Database\DBM\DriverInterface))
					throw new \Database\Exception("{$classname} is not instance of DBM interface");
			}

			return self::$instance;
		}
		
	}