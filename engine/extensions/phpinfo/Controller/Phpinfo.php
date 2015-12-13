<?php
	/**
	 * phpinfo() testing
	 */
	 
	namespace Controller;
	
	class Phpinfo
	{
		function actionIndex()
		{
			phpinfo();
			return;
		}
	}