<?php
	/**
	 * Easy bb-code parser
	 */

	class BBParser
	{
	
		public static $bbcode;
		public static $smiles;
	
		/**
		 * Loads default BBCode library. You can add your own codes
		 * @return void
		 */
		public static function loadLibrary()
		{
			self::$bbcode = array( 
				'[b]' => '<b>', 
				'[/b]' => '</b>', 
				'[img]' => '<img src="', 
				'[/img]' => '">"',
				'[url]' => '<a href="',
				'[/url]' => '">ссылка</a>',
				'[i]' => '<i>',
				'[/i]' => '</i>',
				'[s]' => '<s>',
				'[/s]' => '</s>',
				'[u]' => '<u>',
				'[/u]' => '</u>',
				'[hr]' => '<hr>'
			);
			self::$smiles = array();
		}
	
		public static function parseAll($string)
		{
			$string = self::parseSmiles($string);
			$string = self::parseBB($string);
			return $string;
		}
		
		public static function parseSmiles($string)
		{
			$var = self::$smiles;
			foreach($var as $str => $f)
			{
				if(!is_string($f)) { continue; }
				$string = str_replace($str, "<img alt='" . $f . "' src='" . $f . "'>", $string);
			}
			return $string;
		}
		
		public static function parseBB($string)
		{
			$var = self::$bbcode;
			foreach($var as $str => $replace)
			{
				if(!is_string($replace)) { continue; }
				$string = str_replace($str, $replace, $string);
			}
			return $string;
		}
	}