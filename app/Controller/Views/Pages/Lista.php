<?php

namespace App\Controller\Views\Pages;

use \App\Controller\Views\Views;
use \App\Controller\Views\Modules;
use \App\Utils\View;

class Lista extends Views { 

	/**
	 * Nome do pagina
	 * @var string
	 */
	static private $Page_name = 'lista';

	/**
	 * Metodo responsavel por retorma o conteudo da view Lista
	 * @return string
	 */
	public static function getLista($request){

		//Renderiza a view da Home
		$content = View::render('page/'.self::$Page_name, []);

		//Retorna a view da pagina
		return parent::getPage(self::$Page_name, $content, 'SysCadastro - Lista de cadastros', false);
	}

}
