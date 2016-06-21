<?php
	/**
	 * Universal validator
	 */
	 
	namespace Helpers;
	
	class Validator
	{
		/**
		 * Checks if string is an e-mail
		 * @param string $string 
		 * @return boolean
		 */
		public static function email($string)
		{
			return (bool)preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", trim($string));
		}
		
		/**
		 * Checks if string is a filename
		 * @param string $string 
		 * @return boolean
		 */
		public static function filename($string)
		{
			return (bool)preg_match("/(^[a-zA-Z0-9]+([a-zA-Z\_0-9\.-]*))$/", trim($string));
		}
		
		/**
		 * Checks if string is an ip address
		 * @param string $string 
		 * @return boolean
		 */
		public static function ip($string)
		{
			return (bool)preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/", trim($string));
		}

		/**
		 * Checks if string is an URL
		 * @param string $string 
		 * @return boolean
		 */
		public static function url($string)
		{
			return (bool)preg_match("~(?:(?:ftp|https?)?://|www\.)(?:[a-z0-9\-]+\.)*[a-z]{2,6}(:?/[a-z0-9\-?\[\]=&;#]+)?~i", trim($string)); 
		}
	}