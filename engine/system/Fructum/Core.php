<?php
	namespace Fructum;
	
	class Core
	{
		const SEPARATOR = '\\';
		const EXT = '.php';
		const SYS = 'system';
		const HOOKS = 'hooks';
		const EXT_DIR = 'extensions';
		protected static $root = null;
		
		public static function init()
		{
			self::root();
			spl_autoload_register('Fructum\Core::autoloader');
			set_error_handler('Fructum\Errors::error_handler');
			set_exception_handler('Fructum\Errors::exception_handler');
		}
		
		public static function autoloader($class)
		{
			self::hooks_autoloader($class);
			self::system_autoloader($class);
			self::extensions_autoloader($class);
		}
		
		protected static function hooks_autoloader($class)
		{
			if(class_exists($class, false) or !file_exists(self::root() . self::SEPARATOR . self::HOOKS . self::SEPARATOR . $class . self::EXT)) { return; }
			
			@include_once(self::root() . self::SEPARATOR . self::HOOKS . self::SEPARATOR . $class . self::EXT);
		}
		
		protected static function system_autoloader($class)
		{
			if(class_exists($class, false) or !file_exists(self::root() . self::SEPARATOR . self::SYS . self::SEPARATOR . $class . self::EXT)) { return; }
			
			@include_once(self::root() . self::SEPARATOR . self::SYS . self::SEPARATOR . $class . self::EXT);
		}
		
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
		
		public static function root()
		{
			if(is_null(self::$root)) 
			{  
				self::$root = defined('ROOT') ? ROOT : __DIR__ . '/../../';
			}
			
			return self::$root;
		}
	}