<?php

use \App\Http\Response;
use \App\Controller\Api;

// Rota de API referente a criação de novos cadastros no banco de dados
$obRouter->post('/created/item', [
	'middlewares' => [
		'api',
	],
	function ($request) {
		return new Response(200, Api\Item::setItem($request));
	}
]);

// Rota de login
$obRouter->get('/listed/item', [
	'middlewares' => [
		'api',
	],
	function ($request) {
		return new Response(200, Api\Item::getItems($request));
	}
]);
