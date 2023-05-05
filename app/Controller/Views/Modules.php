<?php

namespace App\Controller\Views;

use \App\Utils\View;
use \App\Session\User\Login as SessionLogin;

class Modules {
	/**
	 * Metodo responsavel por renderizar o Top Bar da pagina
	 * @return string
	 */
	public static function getTopBar() {
		// Verifica se o usuario esta logado
		$islogado = SessionLogin::isLogged();
		if($islogado) {
			$widgetUser = View::render('modules/widget/user/menu');
		} else {
			$widgetUser = View::render('modules/widget/user/login');
		}

		return View::render('modules/all/topbar', [
			'widgetuser' => $widgetUser
		]);
	}

	/**
	 * Metodo responsavel por renderizar o modal responsavel pelo logim e cadastro do usuario
	 * @return string
	 */
	public static function getModal(){
		return View::render('modules/widget/modal/modal');
	}

	/**
	 * Metodo responsavel por renderizar o footer da pagina
	 * @return string
	 */
	public static function getFooter() {
		return View::render('modules/all/footer', [
			'date' => date('Y')
		]);
	}
}
