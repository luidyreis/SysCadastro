<?php
	namespace App\Http\Middleware;

	class Maintenance {
		
		/**
		 * Método responsavel por executar o middleware
		 * @param  Request $request
		 * @param  Closure $next
		 * @return Response
		 */
		public function handle($request, $next) {

			//Verifica no .env se o site esta em manutenção
			if($_ENV['MAINTENANCE'] == 'true') {
				throw new \Exception("Pagina em manutenção. Tente novamente mais tarde.", 200);
			}

			//Execulta o proxino nivel do middleware
			return $next($request);
		}

	}