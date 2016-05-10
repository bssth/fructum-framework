<?php
	/**
	 * Pagination for Fructum Framework
	 */
	
	namespace Helpers;
	
	class Pagination
	{
		/**
		 * How many materials will be shown in one page
		 */
		public $per_page = 0;
		
		/**
		 * Current page
		 */
		public $current_page = 1;
		
		/**
		 * Create instance
		 */
		public function __construct($page = 1)
		{
			$this->per_page = \Fructum\Config::per_page;
			$this->current_page = isset($page) ? $page : 1;
		}
		
		/**
		 * Get materials for current page from array
		 */
		public function fromArray($array)
		{
			$first = $this->current_page * $this->per_page - $this->per_page;
			$last = $this->current_page * $this->per_page;
			
			$res = array();
			for($i = $first; $i < $last; $i++)
			{
				$res[$i] = array_values($array)[$i];
			}
			
			return $res;
		}
		
		/**
		 * Get materials for current page from SQL query (LIMIT will be automatically added)
		 * @param string $query
		 */
		public function fromSQL($query)
		{
			$result = (new \Database\ORM())->query($query . " LIMIT ?i,?i", abs(($this->current_page - 1) * $this->per_page), $this->per_page);
			$res = array();
			while($temp = mysqli_fetch_array($result))
			{
				$res[] = $temp;
			}
			return $res;
		}
	}