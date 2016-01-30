<?php
	/**
	 * This class includes default configuration. To change it, use hooks or extensions
	 *
	 * @author Mike Chip
	 */
	 
	namespace Fructum;
	
	class Config
	{
		
		const cache = '\Memcache'; // cache class name 
		
		const sql_host = '127.0.0.1'; // MySQL host
		const sql_user = 'test2'; // MySQL username
		const sql_password = 'test2'; // MySQL password
		const sql_database = 'test2'; // MySQL database
		const sql_unique = 'id'; // MySQL unique row (id)
		
		const cache_host = '127.0.0.1'; // cache host
		const cache_port = '11211'; // cache_port 
		const cache_timeout = 30; // cache time-out
		const cache_session_timeout = 68400; // sessions time-out if using cache 
		
		const disable_sessions = false; // don't use sessions 
		const session_handler = 'native'; // session handlers (set 'native' if want to use default PHP handler)
		
		const script_time_limit = 0; // script executing time limit 
		const script_ignore_abort = true; // ignore user aborting (for web apps)
		const core_user_root = false; // only for debug 
		const debug = true; // show errors and exception texts
		
	}