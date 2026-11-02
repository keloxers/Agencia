<?php

return array(

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => getenv('DB_HOST'),
			'database'  => getenv('MARIADB_DATABASE'),
			'username'  => getenv('MARIADB_USER'),
			'password'  => getenv('MARIADB_PASSWORD'),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

	),

);
