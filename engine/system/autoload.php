<?php
	
	/**
	 * Fructum autoloader inits root and starts core
	 *
	 * @version 1.0
	 * @author Mike Chip
	 */
	
	define('\Fructum\ROOT', __DIR__ . '/../');
		
	require_once(__DIR__ . '/Fructum/Core.php');
		
	\Fructum\Core::init();