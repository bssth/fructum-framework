<?php
	/**
	 * MongoDB driver for DBManager
	 */
	 
	namespace Database\DBM;
	
	class Mongo implements Template
	{
		
		public $i = null;
		protected $table = null;
		
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
			$this->table = $k;
			return $this;
		}
		
		public function findOne($criteria)
		{
			\Debug\Fuse::addData('mongo_queries', 1);
			return $this->i->{$this->table}->findOne($criteria);
		}
		
		public function find($criteria)
		{
			\Debug\Fuse::addData('mongo_queries', 1);
			return $this->i->{$this->table}->find($criteria);
		}
		
		public function insert($row)
		{
			\Debug\Fuse::addData('mongo_queries', 1);
			return $this->i->{$this->table}->insert($row);
		}
		
		public function update($cr, $data)
		{
			\Debug\Fuse::addData('mongo_queries', 1);
			return $this->i->{$this->table}->update($cr, $data);
		}
		
		public function remove($cr)
		{
			\Debug\Fuse::addData('mongo_queries', 1);
			return $this->i->{$this->table}->remove($cr);
		}
		
		public function asId($id)
		{
			return (is_object($id)) ? $id : (new \MongoId($id));
		}
		
	}