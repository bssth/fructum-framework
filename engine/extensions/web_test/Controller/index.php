<?php
	/**
	 * Controller example
	 */
	 
	namespace Controller;
	
	use Application\Benchmark;

	class Index
	{
		/**
		 * Just send string with script name and server signature to client
		 * 'return' in controller means 'send to output'
		 */
		function actionIndex()
		{
			$benchmark = Benchmark::i();
			$i = 0;
			while($i < 1000){
				echo $i."<br>";
				$i++;
			}
			return "<h3>Fructum works! This controller is placed in following file: <b>". __FILE__ ."</b></h3> {$_SERVER['SERVER_SIGNATURE']} <br>Est. time: ".$benchmark->est_time();
		}
	}