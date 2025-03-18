<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => public_path(),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        's3OldDevBucket' => [
	        'driver' => 's3',
	        'key'    => env('OLD_DEV_AWS_ACCESS_KEY_ID',''),
	        'secret' => env('OLD_DEV_AWS_SECRET_ACCESS_KEY',''),
	        'region' => env('OLD_DEV_AWS_DEFAULT_REGION',''),
	        'bucket' => env('OLD_DEV_AWS_BUCKET',''),
        ],

        's3OldAlphaBucket' => [
	        'driver' => 's3',
	        'key'    => env('OLD_ALPHA_AWS_KEY',''),
	        'secret' => env('OLD_ALPHA_AWS_SECRET',''),
	        'region' => env('OLD_ALPHA_AWS_REGION',''),
	        'bucket' =>  env('OLD_ALPHA_AWS_BUCKET',''),
        ],

        's3OldProductionBucket' => [
	        'driver' => 's3',
	        'key'    => env('S3_KEY',''),
	        'secret' => env('S3_SECRET',''),
	        'region' => env('S3_REGION',''),
	        'bucket' => 'myOtherBucketName',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
