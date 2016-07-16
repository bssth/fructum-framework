<?php
	/**
	 * MongoDB driver for Fructum
	 */
	
	namespace Database\DBM;
	
	class Mysql implements DriverInterface
	{
		protected $i = null;
		protected $last_query = null;
		
		public function __construct()
		{
			if(\Fructum\Config::db_user != null)
			{
				$this->i = new \Database\SafeMySQL([		
					'host'      => \Fructum\Config::db_host,
					'user'      => \Fructum\Config::db_user,
					'pass'      => \Fructum\Config::db_password,
					'db'        => \Fructum\Config::db_database
				]);
			}
			else
			{
				$this->i = new \Database\SafeMySQL();
			}
		}
		
		public function lastError()
		{
			return null;
		}
		
		public function numRows()
		{
			if($this->last_query !== null)
			{
				return $this->i->numRows($this->last_query);
			}
			else
			{
				return 0;
			}
		}
		
		public function getOne($table, $query)
		{
			$args = [];
			foreach($query as $k => $v)
			{
				$args[] = $this->i->parse('?n = ?s', (string)$k, (string)$v); 
			}
			$args[] = '1';
			$args = implode(' AND ', $args);
			
			$this->last_query = $this->i->query('SELECT * FROM ?n WHERE ?p', $table, $args);
			
			$result = $this->i->fetch($this->last_query);
			if(!is_array($result)) {
				return null;
			}
			$iter = $result;
			foreach($iter as $k => $v)
			{
				try {
					$test = unserialize($v);
				}
				catch(\Database\Exception $e){
					continue;
				}
				
				$result[$k] = $test;
			}
			
			\Debug\Fuse::addData('mysql_queries', 1);
			return $result;
		}
		
		public function getAll($table, $query)
		{
			$args = [];
			foreach($query as $k => $v)
			{
				$args[] = $this->i->parse('?n = ?s', (string)$k, (string)$v); 
			}
			$args[] = '1';
			$args = implode(' AND ', $args);
			
			$this->last_query = $this->i->query('SELECT * FROM ?n WHERE ?p', $table, $args);
			
			$ans = [];
			while($a = $this->i->fetch($this->last_query))
			{
				if(!is_array($a)) {
					break;
				}
				
				$iter = $a;
				foreach($iter as $k => $v)
				{
					try {
						$test = unserialize($v);
					}
					catch(\Database\Exception $e){
						continue;
					}
					
					$a[$k] = $v;
				}
				$ans[] = $a;
			}
			
			\Debug\Fuse::addData('mysql_queries', 1);
			return $ans;
		}
		
		public function insert($table, $array)
		{
			$keys = [];
			$values = [];
			$keys[] = '`_id`';
			$values[] = 'NULL';
			
			foreach($array as $k => $v)
			{
				$keys[] = $this->i->parse('?n', $k);
				if(!is_scalar($v)) {
					$v = serialize($v);
				}
				$values[] = $this->i->parse('?s', $v);
			}
			$keys = implode(',', $keys);
			$values = implode(',', $values);
			$this->last_query = $this->i->query('INSERT INTO ?n (?p) VALUES (?p)', $table, $keys, $values);
			
			\Debug\Fuse::addData('mysql_queries', 1);
			return $this->last_query;
		}
		
		public function update($table, $find, $apply)
		{
			$args = [];
			foreach($find as $k => $v)
			{
				$args[] = $this->i->parse('?n = ?s', (string)$k, (string)$v); 
			}
			$args[] = '1';
			$args = implode(' AND ', $args);
			
			$iter = $apply;
			foreach($iter as $k => $v)
			{
				if(!is_scalar($v)) {
					$apply[$k] = serialize($v);
				}
			}
			
			$this->last_query = $this->i->query('UPDATE ?n SET ?u WHERE ?p', $table, $apply, $args);
			
			\Debug\Fuse::addData('mysql_queries', 1);
			return $this->i->affectedRows( $this->last_query );
		}
		
		public function remove($table, $query)
		{
			$args = [];
			foreach($query as $k => $v)
			{
				if(!is_scalar($v)) {
					$v = serialize($v);
				}
				$args[] = $this->i->parse('?n = ?s', (string)$k, (string)$v); 
			}
			$args[] = '1';
			$args = implode(' AND ', $args);
			
			$this->last_query('DELETE FROM ?n WHERE ?p', $table, $args);
			
			\Debug\Fuse::addData('mysql_queries', 1);
			return true;
		}		
	}