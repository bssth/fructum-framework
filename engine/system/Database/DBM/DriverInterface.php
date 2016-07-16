<?php
	/**
	 * Interface for all database drivers
	 */
	
	namespace Database\DBM;
	
	interface DriverInterface
	{
		/**
		 * Init needed classes and handlers for database
		 * @return void
		 */
		public function __construct();
		
		/**
		 * Get last driver error or exception thrown by database handler
		 * @return mixed
		 */
		public function lastError();
		
		/**
		 * Get number of rows returned by last query
		 * @return integer
		 */
		public function numRows();
		
		/**
		 * Get one item from database 
		 * @param string $table 
		 * @param array $query
		 * @return array
		 */
		public function getOne($table, $query);
		
		/**
		 * Get all items from database by pattern
		 * @param string $table 
		 * @param array $query
		 * @return array
		 */
		public function getAll($table, $query);
		
		/**
		 * Insert item to database
		 * @param string $table 
		 * @param array $array
		 */
		public function insert($table, $array);
		
		/**
		 * Update item in database
		 * @param string $table
		 * @param array $find 
		 * @param array $apply 
		 * @return mixed
		 */
		public function update($table, $find, $apply);
		
		/**
		 * Remove item from database 
		 * @param string $table 
		 * @param array $query
		 * @return integer
		 */
		public function remove($table, $query);
	}