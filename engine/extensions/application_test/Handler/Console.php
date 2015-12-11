<?php
	namespace Handler;
	
	class Console
	{
		public function start()
		{
			$app = \Application\ConsoleApp::i();
			$app->output('Hello! Fructum Console works. Input is: 
			');
			foreach($app->input() as $k => $v)
			{
				$app->output("{$k} -> {$v}
				");
			}
		}
	}