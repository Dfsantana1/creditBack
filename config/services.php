<?php

return [
	
	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Mailgun, Postmark, AWS and more. This file provides the de facto
	| location for this type of information, allowing packages to have
	| a conventional file to locate the various service credentials.
	|
	*/
	
	'mailgun' => [
		'domain'   => env('MAILGUN_DOMAIN'),
		'secret'   => env('MAILGUN_SECRET'),
		'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
		'scheme'   => 'https',
	],
	
	'postmark' => [
		'token' => env('POSTMARK_TOKEN'),
	],
	
	'ses' => [
		'key'    => env('AWS_ACCESS_KEY_ID'),
		'secret' => env('AWS_SECRET_ACCESS_KEY'),
		'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
	],
	
	'google' => [
		'client_id'     => env('GOOGLE_ID'),
		'client_secret' => env('GOOGLE_SECRET'),
		'redirect'      => env('GOOGLE_REDIRECT'),
		'project'       => env('GOOGLE_STORAGE_PROJECT'),
		'bucket'        => env('GOOGLE_STORAGE_BUCKET'),
		'key'           => env('GOOGLE_JSON_KEY'),
		'calendar'      => [
			'holiday_key' => env('GOOGLE_CALENDAR_API_KEY')
		],
	],

	'twitter' => [
		'client_id' =>  env('TWITTER_ID'),
		'client_secret' => env('TWITTER_SECRET'),
		'redirect' => env('TWITTER_REDIRECT'),
	],

	'facebook' => [
		'client_id'     => env('FACEBOOK_ID'),
		'client_secret' => env('FACEBOOK_SECRET'),
		'redirect'      => env('FACEBOOK_REDIRECT'),
	],

	'github' => [
		'client_id' => env('GITHUB_ID'),
		'client_secret' => env('GITHUB_SECRET'),
		'redirect' => env('GITHUB_REDIRECT'),
	],
	
	'ffmpeg' => [
		'binary' => env('FFMPEG_BINARY_PATH', '/usr/bin/ffmpeg')
	],
	
	'ffprobe' => [
		'binary' => env('FFPROBE_BINARY_PATH', '/usr/bin/ffprobe')
	],
	
	'pcc' => [
		'certificate_path'     => env('SSL_CERTIFICATE_PATH'),
		'certificate_key_path' => env('SSL_CERTIFICATE_KEY'),
		'api_url'              => env('PCC_API_URL', 'https://connect2.pointclickcare.com'),
		'enabled'              => env('PCC_ENABLED', false),
		'rate_limit'           => 10000,
		'app_name'             => env('PCC_APP_NAME', 'tsolife_test'),
		'webhook_port'         => env('PCC_WEBHOOK_PORT', 443),
		'webhook_base_url'     => env('PCC_WEBHOOK_BASE_URL', env('APP_URL', '')),
		'user'                 => [
			'email'      => env('PCC_ADMIN_USER_EMAIL', 'jignesh.tsolife@gmail.com'),
			'password'   => env('PCC_ADMIN_USER_PASS', 'PCC_ADMIN@359!'),
			'first_name' => env('PCC_ADMIN_USER_FIRST_NAME', 'PCC'),
			'last_name'  => env('PCC_ADMIN_USER_LAST_NAME', 'DEMO')
		],
		'app_key'              => env('PCC_APP_KEY')
	],
	
	'firebase' => [
		'server_api_key' => env('SERVER_API_KEY_FIREBASE')
	],

	'mercadopago' => [
		'token' => env('MERCADO_PAGO_ACCESS_TOKEN'),
		'key' => env('MERCADO_PAGO_PUBLIC_KEY')
	],

	'payu' => [
		'merchant_id' => env('PAYU_MERCHANT_ID'),
		'account_id' => env('PAYU_ACCOUNT_ID'),
		'api_key' => env('PAYU_API_KEY'),
		'api_login' => env('PAYU_API_LOGIN'),
		'public_key' => env('PAYU_PUBLIC_KEY')
	]

];
