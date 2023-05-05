<?php
	namespace App\Http\Middleware;

	use \App\Session\User\Login as SessionLogin;

	class RequireLoginAdmin {

		/**
		 * Método responsavel por executar o middleware
		 * @param  Request $request
		 * @param  Closure $next
		 * @return Response
		 */
		public function handle($request, $next){
			//Verifica se o admin esta logado
			if(!SessionLogin::isAdm()) {
				$request->getRouter()->redirect('/login');
			}
			//Contenua execução
			return $next($request);
		}

	}