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
	
	use \Fructum\Config as Config;
	
	class Core
	{
		// Core constants
		const SEPARATOR = '/';
		const EXT = '.php';
		const MODS = 'modules';
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
			spl_autoload_register('\Fructum\Core::autoloader');
			set_error_handler('\Fructum\Errors::error_handler');
			set_exception_handler('\Fructum\Errors::exception_handler');
			register_shutdown_function('\Fructum\Core::shutdown');
			
			session_write_close();
			
			if(Config::disable_sessions != true) {
				if(Config::session_handler != 'native' and strlen(Config::session_handler))
				{
					$n = Config::session_handler;
					$s = new $n;
					if(@$s->handled != true) { 
						session_set_save_handler( $s, true ); 
					} 
				}
				session_start();
			}
			
			if(Config::script_ignore_abort == true) {
				ignore_user_abort();
			}
			
			set_time_limit(Config::script_time_limit);
			
			\Fructum\EventListener::invoke('ready');
		}
		
		/**
		 * Class autoloader
		 *
		 * @param string $class
		 * @return void
		 */
		public static function autoloader($class)
		{
			$class = str_replace('\\', '/', $class);
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
		 * Module`s classes loader
		 *
		 * @param string $class
		 * @return void
		 *
		 */
		protected static function modules_autoloader($class, $ext)
		{ 
			if(class_exists($class, false)) { return; }
			
			$dir = self::root() . self::SEPARATOR . self::MODS . self::SEPARATOR;
			foreach(scandir($dir) as $f)
			{
				if($f == '.' or $f == '..') { continue; }
				if(substr($f, 0, strlen($ext)) != $ext) { 
					continue; 
				}
				if(!file_exists($dir . self::SEPARATOR . $f . self::SEPARATOR . $class . self::EXT)) { continue; }
				@include_once($dir . self::SEPARATOR . $f . self::SEPARATOR . $class . self::EXT);
			}
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
				if($f == '.' or $f == '..') { continue; }
				
				if(!file_exists($dir . self::SEPARATOR . $f . self::SEPARATOR . $class . self::EXT)) { 
					self::modules_autoloader($class, $f);  
				}
				else {
					@include_once($dir . self::SEPARATOR . $f . self::SEPARATOR . $class . self::EXT); 
				}
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
			\Fructum\EventListener::invoke('shutdown');
			
			if(Config::debug == true) {
				echo call_user_func(Config::debugger . '::asHTML');
			}
		}
	}