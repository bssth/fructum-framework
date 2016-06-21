<?php
	/**
	 * Local fructum cache
	 * @version 0.1
	 */
	
	namespace Fructum;
	
	class Memory
	{
		protected $path = null;
		protected $ext = null;
		
		/**
		 * Append cache path
		 */
		public function __construct()
		{
			$this->path = Core::root() . Core::SEPARATOR . Core::CACHE . Core::SEPARATOR;
			if(!is_dir($this->path))
			{
				throw new Exception("Cannot access cache directory in {$this->path}");
			}
			
			$this->ext = '.mem';
		}
		
		/**
		 * Delete all memory
		 */
		public function flush()
		{
			$dir = scandir($this->path);
			$res = 0;
			foreach($dir as $d)
			{
				if(strstr($d, $this->ext))
				{
					unlink($this->path . $d);
					$res++;
				}
			}
			return $res;
		}
		
		/**
		 * Store variable
		 */
		public function set($key, $value)
		{
			return file_put_contents($this->path . $key . $this->ext, serialize($value));
		}
		
		/**
		 * Get variable from storage
		 */
		public function get($key)
		{
			$data = file_get_contents($this->path . $key . $this->ext);
			return (is_string($data)) ? unserialize($data) : null;
		}
	}