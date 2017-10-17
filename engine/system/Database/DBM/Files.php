<?php
	/**
	 * File-based DB driver for Fructum
	 * 
	 * @version 0.1
	 * @author Mike Chip
	 */
	
	namespace Database\DBM;
	
	class Files implements DriverInterface
	{
		protected $database_dir = null;
		
		public function __construct()
		{
			$this->database_dir = \Fructum\Core::root() . \Fructum\Core::SEPARATOR . \Fructum\Core::DATABASE . \Fructum\Core::SEPARATOR;
		}
		
		public function lastError()
		{
			return null;
		}
		
		public function numRows()
		{
			return null;
		}
		
		public function getAll($table, $query)
		{
			$this->prepareDir($table);
			
			if(isset($query['id']))
				return file_exists($this->database_dir . $table . \Fructum\Core::SEPARATOR . $query['id'])
				? [unserialize(file_get_contents($this->database_dir . $table . \Fructum\Core::SEPARATOR . $query['id']))] : null;
				
			$dir = $this->database_dir . $table;
			$results = [];
			foreach(scandir($dir) as $k => $v)
			{
				if($v == '.' or $v == '..')
					continue;
				
				$arr = unserialize(file_get_contents($dir . \Fructum\Core::SEPARATOR . $v));
				
				if(!count(array_diff_assoc($query, $arr)))
					$results[] = $arr;
			}
			return count($results) ? $results : null;
		}
		
		public function getOne($table, $query)
		{
			$this->prepareDir($table);
			
			if(isset($query['id']))
				return file_exists($this->database_dir . $table . \Fructum\Core::SEPARATOR . $query['id'])
				? unserialize(file_get_contents($this->database_dir . $table . \Fructum\Core::SEPARATOR . $query['id'])) : null;
				
			$dir = $this->database_dir . $table;

			foreach(scandir($dir) as $k => $v)
			{
				if($v == '.' or $v == '..')
					continue;
				
				$arr = unserialize(file_get_contents($dir . \Fructum\Core::SEPARATOR . $v));
				
				if(!count(array_diff_assoc($query, $arr)))
					return $arr;
			}
			
			return null;	
		}		
		
		public function prepareDir($name)
		{
			if(is_dir($this->database_dir . $name))
				return true;
			else
				return mkdir($this->database_dir . $name);
		}
		
		public function insert($table, $array)
		{
			$this->prepareDir($table);
			
			if(!isset($array['id']))
				$array['id'] = uniqid();
			
			file_put_contents($this->database_dir . $table . \Fructum\Core::SEPARATOR . $array['id'], serialize($array));
			return $array['id'];
		}
		
		public function update($table, $find, $apply)
		{
			$this->prepareDir($table);
			
			$dir = $this->database_dir . $table;
			$count = 0;
			foreach(scandir($dir) as $k => $v)
			{
				if($v == '.' or $v == '..')
					continue;
				
				$arr = unserialize(file_get_contents($dir . \Fructum\Core::SEPARATOR . $v));
				
				if(!count(array_diff_assoc($find, $arr))) {
					$new = array_merge($arr, $apply);
					file_put_contents($this->database_dir . $table . \Fructum\Core::SEPARATOR . $arr['id'], serialize($new));
					$count++;
				}
					
			}
			return $count;
		}
		
		public function remove($table, $query)
		{
			$this->prepareDir($table);
			
			$list = $this->getAll($table, $query);
			foreach($list as $k => $v)
				unlink($this->database_dir . $table . \Fructum\Core::SEPARATOR . $v['id']);
			return count($list);
		}		
	}