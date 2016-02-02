<?php
	/**
	 *	Native fructum templater. Uses PHP variables in HTML templates
	 *
	 * @version 1.0 
	 * @author Mike Chip
	 */
	 
	namespace Templater;
	use \Fructum\Core as Core;
	
	class Native
	{
		public $path = '';
		protected $vars = array();
	
		/**
		 * Creating instance. Template name is needed
		 * 
		 * @param string $tpl
		 */
		public function __construct($tpl = 'empty')
		{
			$this->path = file_exists($tpl) ? $tpl : (Core::root() . Core::SEPARATOR . 'templates' . Core::SEPARATOR . $tpl . '.html');
		}
		
		/**
		 * Sets value of variable 
		 * 
		 * @param string $key 
		 * @param mixed $value
		 * @return void
		 */
		public function __set($key, $value)
		{
			$this->vars[$key] = $value;
		}
		
		/**
		 * Gets value of variable 
		 *
		 * @param string $key
		 * @return mixed
		 */
		public function __get($key)
		{
			return ( isset($this->vars[$key]) ? $this->vars[$key] : null );
		}
		
		/**
		 * @see \Templater\Native::__set
		 * @return object
		 */
		public function set($key, $value)
		{
			$this->__set($key, $value);
			\Fructum\EventListener::invoke('tpl_set', $key, $value);
			return $this;
		}
		
		/**
		 * Evaluates code and returns result
		 *
		 * @return string
		 */
		public function render()
		{
			if(!file_exists($this->path)) {
				throw new \Fructum\Exception("Template not found in {$this->path}");
			}
			foreach($this->vars as $k => $v) {
				$$k = $v;
			}
			ob_start(NULL, 0, PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_FLUSHABLE | PHP_OUTPUT_HANDLER_REMOVABLE);
			require_once($this->path);
			\Fructum\EventListener::invoke('tpl_render', $this->vars);
			return ob_get_clean();
		}
	}