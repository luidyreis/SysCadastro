<?php

namespace App\Http\Middleware;

use \App\Model\Entity\User as EntityUser;

class UserBasicAuth {
	
	/**
	 * Método responsavel por retorna uma instancia de usuario autenticado
	 * @return User
	 */	
	private function getBasicAuthUser() {
		
		//Verifica a existencia dos dados de acesso
		if(!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])) {
			return false;
		}

		//Busca o usuario por meio do email
		$obUser = EntityUser::getUserByEmail($_SERVER['PHP_AUTH_USER']);

		if(!$obUser instanceof EntityUser) {
			return false;
		}

		//Sucesso
		return password_verify($_SERVER['PHP_AUTH_PW'],$obUser->User_pass) ? $obUser : false;
	}

	/**
	 * Método responsavel por valida o acesso via HTTP basic auth
	 * @param  Request $request
	 */
	private function basicAuth($request) {
		
		//Verifica o usuario recebido
		if($obUser = $this->getBasicAuthUser()) {
			$request->user = $obUser;
			return true;
		}

		//Emite o erro de senha
		throw new \Exception("Usuario ou senha invalidos", 403);
	}

	/**
	 * Método responsavel por executar o middleware
	 * @param  Request $request
	 * @param  Closure $next
	 * @return Response
	 */
	public function handle($request, $next) {

		//Realiza a validação do acesso via Basic auth
		$this->basicAuth($request);

		//Execulta o proxino nivel de middleware
		return $next($request);
	}
}
