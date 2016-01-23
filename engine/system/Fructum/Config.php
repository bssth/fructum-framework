<?php
	/**
	 * This class includes default configuration. To change it, use hooks or extensions
	 *
	 * @author Mike Chip
	 */
	 
	namespace Fructum;
	
	class Config
	{
		
		const cache = '\Memcache';
		
		const sql_host = '127.0.0.1';
		const sql_user = 'test2';
		const sql_password = 'test2';
		const sql_database = 'test2';
		const sql_unique = 'id';
		
		const cache_host = '127.0.0.1';
		const cache_port = '11211';
		const cache_timeout = 30;
		const cache_session_timeout = 68400;
		
		const disable_sessions = false;
		const session_handler = 'native';
		
		const script_time_limit = 0;
		const script_ignore_abort = true;
		const core_user_root = false;
		const debug = true;
		
	}