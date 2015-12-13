<?php
	/**
	 * Cache class test
	 *
	 * @author Mike Chip
	 */
	
	namespace Controller;
	
	class Cachetest
	{
	
		function actionIndex()
		{	
			// \Database\Cache::$config = array('127.0.0.1', 11211, false);
			$i = \Database\Cache::i();
			
			$value = $i->get('cache_test');
			
			$i->set('cache_test', uniqid(), MEMCACHE_COMPRESSED, 600);
			
			return "Value of 'cache_test' is '{$value}' <br> New value was set for 10 min. Refresh the page.";
		}
		
	}