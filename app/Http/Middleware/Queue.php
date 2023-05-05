<?php
	namespace App\Http\Middleware;

	use \Closure;

	class Queue {

		/**
		 * Mapeamento de middlewares
		 * @var array
		 */
		private static $map = [];

		/**
		 * Mapeamento de middlewares serão carregados em todas as rotas
		 * @var array
		 */
		private static $default = [];

		/**
		 * Fila de middleware a se execultado
		 * @var array
		 */
		private $middlewares = [];

		/**
		 * Função de execulção de controler
		 * @var Closure
		 */
		private $controller;
		
		/**
		 * Argumentos da função do controlador
		 * @var array
		 */
		private $controllerArgs = [];

		/**
		 * Método responsavel por contruir a clase de file de middlewares
		 * @param  array $middlewares
		 * @param  Closure $controller
		 * @param  array $controllerArgs
		 */
		public function __construct($middlewares,$controller,$controllerArgs){
			$this->middlewares    = array_merge(self::$default, $middlewares);
			$this->controller     = $controller;
			$this->controllerArgs = $controllerArgs;
		}
				
		/**
		 * Método responsavel por definir o mapiamento de middewares
		 * @param  array $map
		 */
		public static function setMap($map) {
			self::$map = $map;
		}

		/**
		 * Método responsavel por definir o mapiamento de middewares padrões
		 * @param  array $defaul
		 */
		public static function setDefault($default){
			self::$default = $default;
		}	

		/**
		 * Método responsavel por execulta o proxino nivel da fila de middlewares
		 * @param  Request $request
		 * @return Response
		 */
		public function next($request) {
			//Verifica se a fila esta fasia
			if(empty($this->middlewares)) return call_user_func_array($this->controller,$this->controllerArgs);

			//Middleware
			$middleware = array_shift($this->middlewares);

			//Verifica o mapiamento
			if(!isset(self::$map[$middleware])) {
				throw new \Exception("Problemas ao processar o middleware da requisição", 500);
			}

			//Next
			$queue = $this;
			$next = function($request) use ($queue) {
				return $queue->next($request);
			};

			//Execulta o middleware
			return (new self::$map[$middleware])->handle($request,$next);

		}

	}