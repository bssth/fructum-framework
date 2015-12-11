<?php
	
	/*
	** FRUCTUM Autoload
	**
	**	This file is part of FRUCTUM Framework by Disaytid
	** 	
	** @last_edit 08.12.2015 by Mike
	** @comment Autoloader
	*/
	
	define('Fructum\ROOT', __DIR__);
		
	require_once(__DIR__ . '/Fructum/Core.php');
		
	Fructum\Core::init();