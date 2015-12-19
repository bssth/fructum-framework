<?php
	/**
	 * Templater test
	 *
	 */
	
	namespace Controller;
	
	class Templater
	{
		function actionIndex()
		{
			$obj = new \Templater\Native('test');
			$result = $obj->set('test', 'TEST OK')->render();
			return $result;
		}
	}