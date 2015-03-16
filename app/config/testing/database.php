<?php

return [
	'default' => 'db_testing',
	'connections' => append_config([
		'db_testing' => [
			'driver'   => 'sqlite',
			'database' => base_path('tests/testing.sqlite'),
			'prefix'   => '',
		],
	])
];
