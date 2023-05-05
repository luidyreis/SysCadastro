<?php
	namespace App\Http\Middleware;

	class Api {
		
		/**
		 * Método responsavel por executar o middleware
		 * @param  Request $request
		 * @param  Closure $next
		 * @return Response
		 */
		public function handle($request, $next) {

			//Altera o content type para json
			$request->getRouter()->setContentType('application/json');

			// Verificar a origem da requisição e bloquear ser for diferente
			if (isset($_SERVER['HTTP_REFERER']) && substr($_SERVER['HTTP_REFERER'], 0, strlen($_ENV['URL'])) != $_ENV['URL']) {
				throw new \Exception("Solicitação recusada", 500);
			}

			//Execulta o proxino nivel do middleware
			return $next($request);
		}

	}