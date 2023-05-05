<?php

use \App\Http\Response;
use \App\Controller\Views\Pages;

// Rota da Home
$obRouter->get('/', [
	function ($request) {
		return new Response(200, Pages\Home::getHome($request));
	}
]);


// Rotas de anuncios
$obRouter->get('/list', [
	function ($request) {
		return new Response(200, Pages\Lista::getLista($request));
	}
]);