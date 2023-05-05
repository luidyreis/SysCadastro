<?php

namespace App\Controller\Views\Pages;

use \App\Controller\Views\Views;
use \App\Controller\Views\Modules;
use \App\Utils\View;

class Home extends Views{ 

	/**
	 * Nome do pagina
	 * @var string
	 */
	static private $Page_name = 'home';

	/**
	 * Metodo responsavel por retorma o conteudo da view da home
	 * @return string
	 */
	public static function getHome($request){

		//Renderiza a view da Home
		$content = View::render('page/'.self::$Page_name, []);

		//Retorna a view da pagina
		return parent::getPage(self::$Page_name, $content, 'SysCadastro - Cadastro', false, false);
	}
}
