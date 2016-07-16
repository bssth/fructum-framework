<?php
	/**
	 * Class for working with local files  
	 */
	 
	namespace Helpers;
	
	class Files
	{
		/**
		 * Instance of FructumMemory class
		 */
		protected $memory = null;
		
		/**
		 * Prefix for files 
		 */
		protected $prefix = null;
		
		/**
		 * Create instance
		 * @param string $prefix
		 * @return void
		 */
		public function __construct($prefix = 'file_')
		{
			$this->memory = new \Fructum\Memory;
			$this->prefix = $prefix;
		}
		
		/**
		 * Write to file
		 * @param string $filename 
		 * @param mixed $content
		 * @return boolean
		 */
		public function put($filename, $content)
		{
			return $this->memory->set($this->prefix . $filename, $content);
		}
		
		/**
		 * Upload file using $_FILES variable
		 * @param string $varname
		 * @return string
		 */
		public function upload($varname)
		{
			if(!isset($_FILES[$varname]['tmp_name']))
			{
				throw new \Fructum\Exception('Bad $_FILES variable name');
			}
			
			$filename = md5($_FILES['userfile']['tmp_name']);
			$this->put($filename, file_get_contents($_FILES['userfile']['tmp_name']));
			
			return $filename;
		}
		
		/**
		 * Get file data and content
		 * @param string $filename 
		 * @return array
		 */
		public function get($filename)
		{
			if($this->memory->get($this->prefix . $filename) != null)
			{
				return array(
					'content' => $this->memory->get($this->prefix . $filename),
					'mime' => mime_content_type($this->memory->getPath() . $this->prefix . $filename . $this->memory->getExt()),
					'header' => 'Content-Type: ' . mime_content_type($this->memory->getPath() . $this->prefix . $filename . $this->memory->getExt())
				);
			}
			throw new \Fructum\Exception("File {$filename} not found in cache directory");
			return null;
		}
	}