<?php
	require __DIR__ . '/../vendor/autoload.php';

	use \App\Utils\View;

	use \WilliamCosta\DatabaseManager\Database;
	use \App\Http\Middleware\Queue as MiddlewareQueue;

	//Carrega variaveis de ambiente
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
	$dotenv->load();

	//Defime a confiogurações do banco de dados
	Database::config(
		$_ENV['DB_HOST'],
		$_ENV['DB_NAME'],
		$_ENV['DB_USER'],
		$_ENV['DB_PASS'],
		$_ENV['DB_PORT']
	);

  //Define a Timezone
  date_default_timezone_set($_ENV['TIMEZONE']);

	//Define as variavis vindas do .ENV
	View::init([
		'URL'         => $_ENV['URL'],
		'URL_ASSETS' 	=> $_ENV['URL'] . $_ENV['URL_ASSETS'],
		'URL_IMAGES'	=> $_ENV['URL'] . $_ENV['URL_IMAGES'],
		'URL_UPLOADS'	=> $_ENV['URL'] . $_ENV['URL_UPLOADS'],
		'LANG' 				=> $_ENV['LANG'],
		'KEY_SITE_RECAPTCHA' => $_ENV['KEY_SITE_RECAPTCHA']
	]);

	//Define o mapiamento de middlewares
	MiddlewareQueue::setMap([
		'maintenance' => \App\Http\Middleware\Maintenance::class,
		'required-logout' => \App\Http\Middleware\RequireLogout::class,
		'required-login' => \App\Http\Middleware\RequireLogin::class,
		'required-login-admin' => \App\Http\Middleware\RequireLoginAdmin::class,
		'api' => \App\Http\Middleware\Api::class,
		'user-basic-auth' => \App\Http\Middleware\UserBasicAuth::class
	]);

	//Define o mapiamento de middlewares padrões (Execultados em todas as rotas)
	MiddlewareQueue::setDefault([
		'maintenance',
	]);