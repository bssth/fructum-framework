<?php
	/**
	 * Class provides sessions as files 
	 */

	namespace Sessions; 
	
	class Files
	{
	
		protected $savePath;
		protected $sessionName;
		public $handled;
		
		/**
		 * Setting handlers 
		 */
		public function __construct($handle = true) 
		{
			if($handle == true)
			{
				session_set_save_handler(
					array($this, 'open'), array($this, 'close'), array($this, 'read'), array($this, 'write'), array($this, 'destroy'), array($this, 'gc')
				);
				$this->handled = true;
			}
		}
	
		/**
		 * Opens needed dirs
		 */
		public function open($savePath, $sessionName) 
		{
			$this->savePath = \Fructum\Core::root() . \Fructum\Core::SEPARATOR . 'cache' . \Fructum\Core::SEPARATOR;
			if(!is_dir($this->savePath)) { mkdir($this->savePath, 0777); }
			
			//$this->sessionName = $sessionName;
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
			$data = $this->savePath . $id . '.session';
			if (file_exists($data)) 
			{
				return file_get_contents($data);
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
			file_put_contents( $this->savePath . $id . '.session', $data );
			return true;
		}
		
		/**
		 * Destroyes session 
		 * @param string $id
		 */
		public function destroy($id)
		{
			unlink( $this->savePath . $id . '.session' );
			return true;
		}
		
		/**
		 * Deletes sessions created ages ago
		 * @param string $maxlifetime
		 */
		public function gc($maxlifetime)
		{
			/*$files = scandir( $this->savePath );
			foreach($files as $f) 
			{
				if(!strstr($f, '.session')) { continue; }
				
				if( filectime($this->savePath . $f)+$maxlifetime < time() ) {
					unlink($this->savePath . $f);
				}
			}*/
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
