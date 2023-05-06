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

// Rota de API, retorma um json com todos os item cadastrado no banco de dados
$obRouter->get('/listed/item', [
	'middlewares' => [
		'api',
	],
	function ($request) {
		return new Response(200, Api\Item::getItems($request));
	}
]);

// Rota de API referente a exclusão de item do banco de dados
$obRouter->post('/delet/item', [
	'middlewares' => [
		'api',
	],
	function ($request) {
		return new Response(200, Api\Item::deletItem($request));
	}
]);
