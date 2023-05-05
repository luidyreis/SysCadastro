<?php
	namespace App\Http\Middleware;

	use \App\Session\User\Login as SessionLogin;

	class RequireLogout {

		/**
		 * Método responsavel por executar o middleware
		 * @param  Request $request
		 * @param  Closure $next
		 * @return Response
		 */
		public function handle($request, $next){
			//Verifica se o usuario esta logado
			if(SessionLogin::isLogged()) {
				$request->getRouter()->redirect('/');
			}

			//Contenua execução
			return $next($request);
		}

	}