<?php
$server = [
	'SERVER_URL' => 'http://local.project-name.db',
	'DOMAIN'     => 'project-name.db'
];

$database = [
	'DB_DRIVER'     => 'pgsql',
	'DB_HOST'       => 'localhost',
	'DB_NAME'       => 'project-name',
	'DB_USER'       => 'project-name',
	'DB_PASSWORD'   => 'project-name',
	'DB_SCHEMA'     => 'public'
];

$smtp = [
	'SMTP_HOST' => 'tcp://smtp.intranet.db',
	'SMTP_PORT' => 25,
	'SMTP_GLOBAL_FROM' => serialize([
		'address' => 'info@project-name.com', 'name' => 'ProjectName'
	])
];

$session = [
	'SESSION_DRIVER' => 'file'
];

$cache = [
	'CACHE_DRIVER' => 'memcached',
	'CACHE_SERVERS' => serialize([
		['host' => 'localhost', 'port' => 11211, 'weight' => 100]
	]),
	'CACHE_PREFIX' => 'project-name_'
];

return array_merge(
	$server,
	$database,
	$smtp,
	$session,
	$cache
);