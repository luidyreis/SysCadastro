<?php

	require __DIR__.'/includes/app.php';

	use \App\Http\Router;

	$obRouter = new Router($_ENV['URL']);

	//Inclue as rotas da pagina
	require __DIR__.'/routes/web.php';
	//Inclue as rotas da pagina
	require __DIR__ . '/routes/api.php';


	//Imprime o response da rota
	$obRouter->run()->sendResponse();