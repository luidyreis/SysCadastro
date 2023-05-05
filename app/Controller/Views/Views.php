<?php

namespace App\Controller\Views;

use \App\Utils\View;
use \App\Controller\Views\Modules;

class Views {
	/**
	 * Metodo responsavel por renderizar e enviar todas as configurações da pagina que esta sendo requisitada.
	 * @param string $page_name
	 * @param string $content
	 * @param string $title
	 * @param boolean $isLoadTopbarFooter
	 * @param boolean $isLoadModal
	 * @return string
	 */
	public static function getPage($page_name, $content, $title, $isLoadTopbarFooter = true, $isLoadModal = true){	
		//Carrega os assets e scripts na pagina
		$assets = !is_null(View::assets($page_name)) ? View::assets($page_name) : View::assets('all');
		$scripts = !is_null(View::scripts($page_name)) ? View::scripts($page_name) : View::scripts('all');

		// Verifica se a apagina precissar carregar o topbar e o footer
		switch ($isLoadTopbarFooter) {
			case true:
				return View::render('index', [
					'title'   => $title,
					'assets'  => $assets,
					'topbar'  => Modules::getTopBar(),
					'content' => $content,
					'footer'  => Modules::getFooter(),
					'modal' => Modules::getModal(),
					'scripts' => $scripts
				]);

			case false:
				return View::render('index', [
					'title'   => $title,
					'assets'  => $assets,
					'topbar'  => '',
					'content' => $content,
					'footer'  => '',
					'modal' => $isLoadModal == true ? Modules::getModal() : '',
					'scripts' => $scripts
				]);
		}

	}

}
