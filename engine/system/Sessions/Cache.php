<?php
	/**
	 * Class provides sessions using memcache
	 */

	namespace Sessions; 
	
	class Cache
	{
		/**
		 * Opens needed dirs
		 */
		public function open() 
		{
			return true;
		}
		
		/**
		 * Closes needed dirs
		 */
		public function close() 
		{
			return true;
		}
		
		/**
		 * Reads session data 
		 * @param string $id 
		 */
		public function read($id) 
		{
			$data = \Database\Cache::i()->get('session_' . $id);
			if (is_string($data)) 
			{
				return $data;
			}
			else 
			{
				$this->write($id, '');
				return "";
			}
		}
		
		/**
		 * Writes session data 
		 * @param string $id 
		 * @param string $data
		 */
		public function write($id, $data) 
		{
			\Database\Cache::i()->set('session_' . $id, $data, MEMCACHE_COMPRESSED, \Fructum\Config::cache_session_timeout);
                        return true;
		}
		
		/**
		 * Destroyes session 
		 * @param string $id
		 */
		public function destroy()
		{
			//\Database\Cache::i()->remove('session_' . $id);
			return true;
		}
		
		/**
		 * Deletes sessions created ages ago
		 * @param string $maxlifetime
		 */
		public function gc()
		{
			return true;
		}
		
		/**
		 * Creates new session ID
		 */
		public function create_sid()
		{
			return md5( uniqid( rand(0,999) ) );
		}

	}
