<?php	
	namespace App\Http;

	use \Closure;
	use \Exception;
	use \ReflectionFunction;
	use \App\Http\Middleware\Queue as MiddlewareQueue;

	class Router {
		
		/**
		 * URL completa da raiz do projeto
		 * @var string
		 */
		private $url = '';

		/**
		 * Prefixo de todas as rotas
		 * @var string
		 */
		private $prefix = '';

		/**
		 * Indece das rotas
		 * @var array
		 */
		private $routes = [];

		/**
		 * Instancia de Request
		 * @var Request
		 */
		private $request;
		
		/**
		 * contentType padrão do response
		 * @var string
		 */
		private $contentType = 'text/html';
		
		/**
		 * Metodo responsavel por inicia a classe
		 * @param string $url
		 */
		public function __construct($url){
			$this->request = new Request($this);
			$this->url     = $url;
			$this->setPrefix();
		}
		
		/**
		 * Método responsalve por autera o valor de contentype
		 * @param  string $contentType
		 * @return void
		 */
		public function setContentType($contentType) {
			$this->contentType = $contentType;
		}
		
		/**
		 * Metodo responsavel por definir o prefix das rotas
		 * @return void
		 */
		private function setPrefix(){
			//Informaçõos da url atual
			$parseUrl = parse_url($this->url);

			//Define o prefix
			$this->prefix = $parseUrl['path'] ?? '';
		}
		
		/**
		 * Método responsavel por adiciona uma rota na classe
		 * @param  string $method
		 * @param  string $routes
		 * @param  array $params
		 */
		private function addRoute($method,$route,$params = []) {
			//Validação dos parametros
			foreach($params as $key=>$value) {
				if($value instanceof Closure) {
					$params['controller'] = $value;
					unset($params[$key]);
					continue;
				}
			}

			//Middlewares das rotas
			$params['middlewares'] = $params['middlewares'] ?? [];
 
			//Variaveis da rota
			$params['variables'] = [];

			//Padrão de validação das variaveis das rotas
			$patternVariable = '/{(.*?)}/';
			if(preg_match_all($patternVariable,$route,$matches)) {
				$route = preg_replace($patternVariable,'(.*?)',$route);
				$params['variables'] = $matches[1];
			}

			//Padrão de validação de URL
			$patternRoute = '/^'.str_replace('/','\/',$route).'$/';

			//Adicina a rota dentro da classe
			$this->routes[$patternRoute][$method] = $params;
		}
		
		/**
		 * Método responsavel por defirmi uma rota GET
		 * @param  string $route
		 * @param  array $params
		 */
		public function get($route,$params = []) {
			return $this->addRoute('GET',$route,$params);
		}

		/**
		 * Método responsavel por defirmi uma rota POST
		 * @param  string $route
		 * @param  array $params
		 */
		public function post($route, $params = [])
		{
			return $this->addRoute('POST', $route, $params);
		}

		/**
		 * Método responsavel por defirmi uma rota PUT
		 * @param  string $route
		 * @param  array $params
		 */
		public function put($route, $params = [])
		{
			return $this->addRoute('PUT', $route, $params);
		}

		/**
		 * Método responsavel por defirmi uma rota DELETE
		 * @param  string $route
		 * @param  array $params
		 */
		public function delete($route, $params = [])
		{
			return $this->addRoute('DELETE', $route, $params);
		}
		
		/**
		 * Metodo responsavel por retorma a uri desomsiderando o prefiz
		 * @return string
		 */
		private function getUri() {
			//Uri da request
			$uri = $this->request->getUri();

			//Fatia a URI com prefix
			$xUri = strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri];

			//Retorma a URI sem o PREFIX
			if(end($xUri) == '/') {
				return end($xUri);
			}else {
				return rtrim(end($xUri), '/');
			}
		/* 	echo '<pre>';
			print_r($xUri);
			echo '</pre>'; */
		}
				
		/**
		 * Método responsavel por retorma os dados da rota atual
		 * @return array
		 */
		private function getRoute() {
			//URI
			$uri = $this->getUri();
			
			//Metodo
			$httpMethod = $this->request->getHttpMethod();
			
			//Valida as rotas
			foreach($this->routes as $patternRoute=>$methods) {
				//Verifica se a URI bate com o padrão
				if(preg_match($patternRoute,$uri,$matches)) {
					//Verifica o metodo
					if(isset($methods[$httpMethod])){
						//Renover o index 0
						unset($matches[0]);

						//Variaves processadas
						$keys = $methods[$httpMethod]['variables'];
						$methods[$httpMethod]['variables'] = array_combine($keys,$matches);
						$methods[$httpMethod]['variables']['request'] = $this->request;

						//Retorm dos parametros da rota
						return $methods[$httpMethod];
					}
					//Metodo não permitido ou idefinido
					throw new Exception("Método não permitido", 405);
				}
			}

			//URL na encontrada
			throw new Exception("URL não encontrada", 404);
		}

		/**
		 * Método responsavel por executa a rota atual
		 * @return Response
		 */
		public function run() {
			try{
				//Routa atual
				$route = $this->getRoute();
				
				//Verfica o controlador
				if(!isset($route['controller'])) {
					throw new Exception("A URL não pode ser processada", 500);
				}

				//Argumentos da função
				$args = [];

				//Reflection
				$reflection = new ReflectionFunction($route['controller']);
				foreach($reflection->getParameters() as $parameter) {
					$name = $parameter->getName();
					$args[$name] = $route['variables'][$name] ?? '';
				}

				//Retrona a exexulçao da fila de middlewares
				return (new MiddlewareQueue($route['middlewares'],$route['controller'],$args))->next($this->request);
			}catch(Exception $e){
				return new Response($e->getCode(),$this->getErrorMessage($e->getMessage()), $this->contentType);
			}
		}
		
		/**
		 * Método resonsavel por retorma a messagen de erro de acordo com o contentType
		 * @param  string $message
		 * @return mixed
		 */
		private function getErrorMessage($message) {
			switch ($this->contentType) {
				case 'application/json':
					return [
						'error' => $message
					];
					break;
				default:
					return $message;
					break;
			}
		}
		
		/**
		 * Método resposnavel por retorma a url atual
		 * @return string
		 */
		public function getCurrentUrl() {
			return $this->url.$this->getUri();
		}
		
		/**
		 * Método responsavel por redirecionar a URL
		 * @param  string $route
		 */
		public function redirect($route) {
			//URL
			$url = $this->url.$route;
			
			//Execulta o redirect
			header('Location: '.$url);
			exit();
		}

	}