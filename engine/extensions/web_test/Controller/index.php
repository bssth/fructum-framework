<?php
	namespace Controller;
	
	class index
	{
		function action_index()
		{
			return "<h3>Fructum works! This controller is placed in following file: <b>". __FILE__ ."</b></h3> {$_SERVER['SERVER_SIGNATURE']}";
		}
	}