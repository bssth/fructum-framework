<?php
	/**
	 * Object-relational mapping of MySQL database
	 * 
	 * @author Mike Chip
	 * @version 1.1
	 */
	 
	namespace Database;
	use \Fructum\Config as Conf;
	
	class ORM extends \Fructum\Instancer
	{
		
		protected $_db = null;
		
		protected $_config = null;
		protected $_tables = array();
		protected $_save = array();
		
		protected $_current_table = null;
		protected $_current_row = null;
		
		/**
		 * Loading configuration and saving it into class variable
		 * 
		 * @param array $config
		 */
		function __construct($config = null)
		{
			$this->_config = is_array($config) ? $config : array(
				'host' => Conf::sql_host,
				'user' => Conf::sql_user,
				'pass' => Conf::sql_password,
				'db' => Conf::sql_database,
			);
			
			$this->_db = new SafeMySQL($this->_config);
		}
		
		/**
		 * Selecting table as current
		 *
		 * @param string $tablename
		 * @return object
		 */
		public function table($tablename)
		{
			$this->_current_table = is_string($tablename) ? $tablename : null;
			return $this;
		}
		
		/**
		 * Selecting row as current (using sql SELECT)
		 *
		 * @param array $criteria
		 * @return object
		 */
		public function row($criteria)
		{
			$this->_current_row = $this->_db->getOne( 'SELECT * FROM ?n WHERE ?u', $this->_current_table, $criteria );
			return $this;
		}
		
		/**
		 * Getting all rows 
		 *
		 * @param array $criteria
		 * @return array
		 */
		public function rows($criteria)
		{
			return $this->_db->getAll( 'SELECT * FROM ?n WHERE ?u', $this->_current_table, $criteria );
		}
		
		/**
		 * Advanced selecting. Every criteria in different argument. For example: ->where('time >= 1', 'id < 5')
		 */
		public function where()
		{
			$arr = (count(func_get_args()) > 1) ? implode(' AND ', func_get_args()) : func_get_arg(1);
			$this->_current_row = $this->_db->getRow( 'SELECT * FROM ?n WHERE ?p', $this->_current_table, $arr );
			return $this;
		}
		
		/**
		 * Gets value of selected row`s col
		 *
		 * @param string $key
		 */
		public function __get($key)
		{
			return isset($this->_current_row[$key]) ? $this->_current_row[$key] : null;
		}
		
		/**
		 * Sets value of selected row`s col
		 *
		 * @param string $key 
		 * @param mixed $value
		 */
		public function __set($key, $value)
		{
			$uniq = Conf::sql_unique;
			$this->_current_row[$key] = $value;
			$uniq = isset($this->_current_row[$uniq]) ? $this->_current_row[$uniq] : 0;
			if(!isset($this->_save[$this->_current_table])) { $this->_save[$this->_current_table] = array(); }
			if(!isset($this->_save[$this->_current_table][$uniq])) { $this->_save[$this->_current_table][$uniq] = array(); }
			$this->_save[$this->_current_table][$uniq][$key] = $value;
		}
		
		/**
		 * Saves all changes to database
		 */
		public function save()
		{
			foreach($this->_save as $key => $value)
			{
				foreach($value as $k => $v)
				{
					$this->_db->query('UPDATE ?n SET ?u WHERE ?n = ?s', $key, $v, Conf::sql_unique, $k);
				}
			}
		}
		
		/**
		 * Advanced multiple selecting. Every criteria in different argument. For example: ->where('time >= 1', 'id < 5')
		 */
		public function wheres()
		{
			return $this->_db->getAll( 'SELECT * FROM ?n WHERE ?p', $this->_current_table, implode(' AND ', func_get_args()) );
		}
		
		/*
		 * Getting row info as array
		 * 
		 * @return array
		 */
		public function as_array()
		{
			return $this->_current_row;
		}

	}