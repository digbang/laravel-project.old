<?php
return [
    'proxies' => [
        'directory' => storage_path('proxies'),
	    'autogenerate' => Config::get('app.debug')
    ],
    'migrations' => [
        'directory'  => null,
        'namespace'  => null,
        'table_name' => null
    ]
];
