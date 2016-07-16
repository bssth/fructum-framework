<?php
	/**
	 * MongoDB driver for DBManager
	 */
	 
	namespace Database\DBM;
	
	class Mongo implements DriverInterface
	{
		
		public $i = null;
		protected $table = null;
		
		public function __construct()
		{
			if(\Fructum\Config::db_user != null)
			{
				$this->i = new \MongoClient('mongodb://' . \Fructum\Config::db_user . ':' . \Fructum\Config::db_password . '@' . \Fructum\Config::db_host);
			}
			else
			{
				$this->i = new \MongoClient(\Fructum\Config::db_host);
			}
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
			
			if(isset($criteria['_id']) and !is_object($criteria['_id'])) {
				$criteria['_id'] = new \MongoId($criteria['_id']);
			}
			
			return $this->i->{$this->table}->findOne($criteria);
		}
		
		public function find($criteria)
		{
			\Debug\Fuse::addData('mongo_queries', 1);
			
			if(isset($criteria['_id']) and !is_object($criteria['_id'])) {
				$criteria['_id'] = new \MongoId($criteria['_id']);
			}
			
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
			
			if(isset($cr['_id']) and !is_object($cr['_id'])) {
				$cr['_id'] = new \MongoId($cr['_id']);
			}
			if(isset($data['_id']) and !is_object($data['_id'])) {
				$data['_id'] = new \MongoId($data['_id']);
			}
			
			return $this->i->{$this->table}->update($cr, $data)['nModified'];
		}
		
		public function remove($cr)
		{
			\Debug\Fuse::addData('mongo_queries', 1);
			return $this->i->{$this->table}->remove($cr)['ok'];
		}
		
	}