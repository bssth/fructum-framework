<?php
	/**
	 * MongoDB driver for DBManager
	 */
	 
	namespace Database\DBM;
	
	class Mongo implements Template
	{
		
		public $i = null;
		
		public function __construct()
		{
			$this->i = \Database\Mongo::i(); // saves instance of MongoClient object with active connection
		}
		
		public function __get($k)
		{
			return $this->table($k);
		}
		
		public function table($k)
		{
			$this->i = $this->i->$k;
			return $this;
		}
		
		public function findOne($criteria)
		{
			return $this->i->findOne($criteria);
		}
		
		public function find($criteria)
		{
			return $this->i->find($criteria);
		}
		
		public function insert($row)
		{
			return $this->i->insert($criteria);
		}
		
		public function update($cr, $data)
		{
			return $this->i->update($cr, $data);
		}
		
		public function remove($cr)
		{
			return $this->i->remove($cr);
		}
		
	}