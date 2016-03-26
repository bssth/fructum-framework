<?php
	
	/**
	 * Fructum autoloader inits root and starts core
	 *
	 * @version 1.1
	 * @author Mike Chip
	 */
	
	require_once(__DIR__ . '/Fructum/Core.php'); // loading core 
		
	\Fructum\Core::init(); // init core