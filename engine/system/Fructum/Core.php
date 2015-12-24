<?php
	
	/**
	 * Fructum Framework Core
	 *
	 * @version 1.0
	 * @author Mike Chip
	 * @todo Optimization
	 *
	 */
	 
	namespace Fructum;
	
	class Core
	{
		// Core constants
		const SEPARATOR = '\\';
		const EXT = '.php';
		const SYS = 'system';
		const HOOKS = 'hooks';
		const EXT_DIR = 'extensions';
		protected static $root = null;
		
		/**
		 * Inits frameworks and sets handlers
		 * @return void
		 */
		public static function init()
		{
			self::root();
			spl_autoload_register('Fructum\Core::autoloader');
			set_error_handler('Fructum\Errors::error_handler');
			set_exception_handler('Fructum\Errors::exception_handler');
			register_shutdown_function('\Fructum\Core::shutdown');
			
			session_write_close();
			if(Config::session_handler != 'native' and strlen(Config::session_handler))
			{
				$n = Config::session_handler;
				$s = new $n;
				if(@$s->handled != true) { 
					session_set_save_handler( $s, true ); 
				} 
			}
			
			session_start();
			ignore_user_abort();
			set_time_limit(Config::script_time_limit);
		}
		
		/**
		 * Class autoloader
		 *
		 * @param string $class
		 * @return void
		 */
		public static function autoloader($class)
		{
			self::hooks_autoloader($class);
			self::system_autoloader($class);
			self::extensions_autoloader($class);
		}
		
		/**
		 * Hooks loader
		 *
		 * @param string $class
		 * @return void
		 *
		 */
		protected static function hooks_autoloader($class)
		{
			if(class_exists($class, false) or !file_exists(self::root() . self::SEPARATOR . self::HOOKS . self::SEPARATOR . $class . self::EXT)) { return; }
			
			@include_once(self::root() . self::SEPARATOR . self::HOOKS . self::SEPARATOR . $class . self::EXT);
		}
		
		/**
		 * System classes loader
		 *
		 * @param string $class
		 * @return void
		 *
		 */
		protected static function system_autoloader($class)
		{
			if(class_exists($class, false) or !file_exists(self::root() . self::SEPARATOR . self::SYS . self::SEPARATOR . $class . self::EXT)) { return; }
			
			@include_once(self::root() . self::SEPARATOR . self::SYS . self::SEPARATOR . $class . self::EXT);
		}
		
		/**
		 * Extension`s classes loader
		 *
		 * @param string $class
		 * @return void
		 *
		 */
		protected static function extensions_autoloader($class)
		{
			if(class_exists($class, false)) { return; }
			
			$dir = self::root() . self::SEPARATOR . self::EXT_DIR . self::SEPARATOR;
			foreach(scandir($dir) as $f)
			{
				if(!file_exists($dir . self::SEPARATOR . $f . self::SEPARATOR . $class . self::EXT)) { continue; }
				@include_once($dir . self::SEPARATOR . $f . self::SEPARATOR . $class . self::EXT);
			}
		}
		
		/**
		 * Init or just return framework root
		 *
		 * @return string
		 */
		public static function root()
		{
			if(is_null(self::$root)) 
			{  
				self::$root = defined('ROOT') ? ROOT : __DIR__ . '/../../';
			}
			
			return self::$root;
		}
		
		/**
		 * Handles shutting down
		 */
		public static function shutdown()
		{
			
		}
	}