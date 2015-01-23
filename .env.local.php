<?php
return [
	// Server configuration
	'SERVER_URL' => 'http://local.project-name.db',
	'DOMAIN'     => 'project-name.db',
	// Database configuration
	'DB_DRIVER'     => 'pgsql',
	'DB_HOST'       => 'localhost',
	'DB_NAME'       => 'project-name',
	'DB_USER'       => 'project-name',
	'DB_PASSWORD'   => 'project-name',
	'DB_SCHEMA'     => 'public',
	// Smtp configuration
	'SMTP_HOST' => 'tcp://smtp.intranet.db',
	'SMTP_PORT' => 25,
	'SMTP_GLOBAL_FROM' => serialize([
		'address' => 'info@project-name.com', 'name' => 'ProjectName'
	]),
	// Session configuration
	'SESSION_DRIVER' => 'file',
	// Cache configuration
	'CACHE_DRIVER' => 'memcached',
	'CACHE_SERVERS' => serialize([
		['host' => 'localhost', 'port' => 11211, 'weight' => 100]
	]),
	'CACHE_PREFIX' => 'project-name_'
];