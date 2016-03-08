<?php
	/**
	 * Template for all database types
	 */
	 
	namespace Database\DBM;
	
	interface Template
	{
		
		public function __get($table); // selecting table\collection
		
		public function table($name); // __get acronym
		
		public function findOne($criteria); // get one row from table
		
		public function find($criteria); // get all rows from table
		
		public function insert($data); // insert row to table
		
		public function update($criteria, $data); // update row
		
		public function remove($criteria); // remove row
		
		public function asId($id); // converts string to ID object, array etc.
		
	}