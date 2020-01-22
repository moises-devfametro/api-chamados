<?php

 return [
     'default' => 'mysql',
     'migrations' => 'migrations',
     'connections' => [
         'mysql' => [
             'driver'    => 'mysql',
             'host'      => env('DB_HOST', '127.0.0.1'),
             'port'      => env('DB_PORT', 3306),
             'database'  => env('DB_DATABASE', 'forge'),
             'username'  => env('DB_USERNAME', 'forge'),
             'password'  => env('DB_PASSWORD', ''),
             'charset'   => env('DB_CHARSET', 'utf8'),
             'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
         ],
         'RM' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_RM', 'localhost'),
            'port' => env('DB_PORT_RM', '1433'),
            'database' => env('DB_DATABASE_RM', 'forge'),
            'username' => env('DB_USERNAME_RM', 'forge'),
            'password' => env('DB_PASSWORD_RM', ''),
            'charset' => 'UTF-8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],
     ]
 ];
