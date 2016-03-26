<?php
	/**
	 * Class provides parsing request string
	 */
	 
	 namespace Web;
	 
	 class Router
	 {
		
		/**
		 * Parses request string
		 * @param string $route 
		 * @return array
		 */
		public static function getRoute($route)
		{
			if(strpos($route, '?') != false and strpos($route, '?') >= 0) { 
				$route = trim(strstr($route, '?', true), '?'); 
			}
			
			$urlArray = @explode("/", $route);
			
			if(is_array($urlArray)) 
			{
				if (empty($urlArray[1])) 
				{
					$urlArray[1] = "index";
				}
				if (empty($urlArray[2])) 
				{
					$urlArray[2] = "index";
				} 
			}
			else {
				$urlArray = array(false, 'index', 'index');
			}

			return $urlArray;
		}
		
		/**
		 * Converts controller name to classname 
		 * @param string $route 
		 * @return string
		 */
		public static function getClassName($route)
		{
			return "\\Controller\\" . ucfirst(strtolower($route));
		}
		 
	 }