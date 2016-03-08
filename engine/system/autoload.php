<?php
	
	/**
	 * Fructum autoloader inits root and starts core
	 *
	 * @version 1.0
	 * @author Mike Chip
	 */
	
	define('\Fructum\ROOT', __DIR__ . '/../'); // defines engine root 
		
	require_once(__DIR__ . '/Fructum/Core.php'); // loading core 
		
	\Fructum\Core::init(); // init core