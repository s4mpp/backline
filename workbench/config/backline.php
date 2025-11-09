<?php

use function Orchestra\Testbench\workbench_path;

return [
	'guard' => 'web',

	'color' => 'orange',

	'subdomain' => env('ADMIN_SUBDOMAIN'),
	
	'resources_path' => workbench_path('app/AdminPanel'),
	
	'namespace' => 'Workbench\\App',

	// 'middlewares' => [
	// 	AdminScopes::class
	// ],
];