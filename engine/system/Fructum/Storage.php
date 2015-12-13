<?php 
	/**
	 * Simple variable storage
	 *
	 * @author Mike Chip
	 */
	 
	namespace Fructum;
	 
	class Storage
	{
		protected $data = array();
		
		public function set($key, $value) { $this->__set($key, $value); }
		public function get($key) { return $this->__get($key); }
		public function __call($f, $a) { return true; }
		public static function __callStatic($f, $a) { return true; }
		
		/**
		 * Set variable
		 *
		 * @param string $key
		 * @param mixed $value
		 */
		function __set($key, $value)
		{
			$this->data[$key] = $value;
		}
		
		/**
		 * Get variable
		 *
		 * @param string $key
		 */
		function __get($key)
		{
			return isset($this->data[$key]) ? $this->data[$key] : null;
		}
	}