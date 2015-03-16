<?php
return [
	// Server configuration
	'SERVER_URL' => 'http://local.project-name.db',
	'DOMAIN'     => 'project-name.db',
	'DEBUG_MODE' => true,
	'TIMEZONE'   => 'America/Argentina/Buenos_Aires',

	// Database configuration
	'DB_DRIVER'   => 'pgsql',
	'DB_HOST'     => 'localhost',
	'DB_NAME'     => 'project-name',
	'DB_USER'     => 'project-name',
	'DB_PASSWORD' => 'project-name',
	'DB_SCHEMA'   => 'public',

	// SMTP configuration
	'SMTP_HOST'                => 'tcp://smtp.intranet.db',
	'SMTP_PORT'                => 25,
	'SMTP_USERNAME'            => null,
	'SMTP_PASSWORD'            => null,
	'SMTP_GLOBAL_FROM_NAME'    => 'ProjectName',
	'SMTP_GLOBAL_FROM_ADDRESS' => 'info@project-name.com',

	// Session configuration
	'SESSION_DRIVER' => 'file',

	// Cache configuration
	'CACHE_DRIVER' => 'array',
	'CACHE_SERVERS' => serialize([
		['host' => 'localhost', 'port' => 11211, 'weight' => 100]
	]),
	'CACHE_PREFIX' => 'project-name_'
];