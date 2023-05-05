<?php

namespace App\Controller\Api;


class Api {

	/**
	 * Método responsavel por autenticar usuarias via api
	 * @param mixed $request
	 * @return void
	 */
	public static function verifiRecaptcha($request){
		//Captura os dados enviados pelo formulario
		$postVars = $request->getPostVars();
		$captcha = isset($postVars['g-recaptcha-response']) ? $postVars['g-recaptcha-response'] : null;

		//Verifica se o recaptcha esta vazio
		if (!isset($captcha)) {
			$retorno = array('codigo' => 1, 'mensagem' => 'Captcha não preenchido!');
			echo json_encode($retorno);
			exit();
		}

		//Verifica se o recaptcha e valido
		$res = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $_ENV['KEY_SECRET_RECAPTCHA'] . "&response=" . $captcha . "&remoteip=rocket"));
		if (!$res->success === true) {
			$retorno = array('codigo' => 1, 'mensagem' => 'Erro ao validar o captcha!');
			echo json_encode($retorno);
			exit();
		}
	}

  public static function returnJson($cod, $msg) {
		return json_encode(array('codigo' => $cod, 'mensagem' => $msg));
  }
}
