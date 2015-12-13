<?php
	/**
	 * Controller example
	 */
	 
	namespace Controller;
	
	class Index
	{
		/**
		 * Just send string with script name and server signature to client
		 * 'return' in controller means 'send to output'
		 */
		function actionIndex()
		{
			return "<h3>Fructum works! This controller is placed in following file: <b>". __FILE__ ."</b></h3> {$_SERVER['SERVER_SIGNATURE']}";
		}
	}