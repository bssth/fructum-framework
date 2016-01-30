<?php
	/** 
	 * Event listener class
	 * @author Mike Chip
	 * @version 0.1
	 */
	 
	namespace Fructum;
	
	class EventListener
	{
		/**
		 * Events list and its listen-functions
		 */
		protected static $events = array();
		
		/** 
		 * Returns list of all registered events
		 * @return array
		 */
		public static function getEvents()
		{
			return array_keys(self::$events);
		}
		
		/**
		 * Invokes all event handlers and returns their count
		 * @param string $event 
		 * @return integer
		 */
		public static function invoke($event)
		{
			if(!isset(self::$events[$event])) { return null; }
			foreach(self::$events[$event] as $n => $func) {
				call_user_func_array($func, func_get_args());
			}
			return count(self::$events[$event]);
		}
		
		/**
		 * Adds event handler 
		 * @param string $event 
		 * @param callable $func 
		 */
		public static function add($event, $func)
		{
			if(is_string($event) and is_callable($func)) {
				self::$events[$event][] = $func;
				return count(self::$events[$event]);
			}
			else {
				throw new Exception('Bad event name or listener');
				return null;
			}
		}
		
		/**
		 * You can also create new object, it adds event handler 
		 * @see EventListener::add
		 */
		public function __construct($e, $f) {
			EventListener::add($e, $f);
		}
	}