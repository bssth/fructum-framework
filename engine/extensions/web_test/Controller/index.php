<?php
	/**
	 * Controller example
	 */
	 
	namespace Controller;
	
	use Unittest\Benchmark;

	class Index
	{
		/**
		 * Just send string with script name, server signature and loading time to client
		 * 'return' in controller means 'send to output'
		 */
		function actionIndex()
		{
			$benchmark = Benchmark::i();

			return "<h3>Fructum works! This controller is placed in following file: <b>". __FILE__ ."</b></h3> {$_SERVER['SERVER_SIGNATURE']} <br>Est. time: ".$benchmark->est_time();
		}
	}