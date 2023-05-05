<?php
	namespace App\Http;

	class Request {

		/**
		 * Instancia do Router
		 * @var Router
		 */
		private $router;

		/**
		 * Metodo HTTP da requisição
		 * @var string
		 */
		private $httpMethod;
		
		/**
		 * Uri da pagina
		 * @var string
		 */
		private $uri;
		
		/**
		 * Parametros da URI ($_GET)
		 * @var array
		 */
		private $queryParams = [];

		/**
		 * Parametros da URI ($_POST)
		 * @var array
		 */
		private $postVars = [];
		
		/**
		 * Cabeçalho da requisição
		 * @var array
		 */
		private $headers = [];

		public function __construct($router){
			$this->router       = $router;
			$this->queryParams 	= $_GET ?? [];
			$this->postVars    	= $_POST ?? [];
			$this->httpMethod 	= $_SERVER['REQUEST_METHOD'] ?? '';
			$this->setURI();
		}

		/**
		 * Método reposponsavel por defimir a URI
		 */
		private function setURI() {
			//URI completa com GETs
			$this->uri = $_SERVER['REQUEST_URI'] ?? '';

			//Remover os GETs da URI
			$xURI = explode('?',$this->uri);
			$this->uri = $xURI[0];
		}

		/**
		 * Método responsavel por retorma a instancia do router
		 * @return Router
		 */
		public function getRouter() {
			return $this->router;
		}

		/**
		 * Metodo reponsavel por retorma o metodo HTTP
		 * @return string
		 */
		public function getHttpMethod() {
			return $this->httpMethod;
		}

		/**
		 * Metodo reponsavel por retorma o Uri da requisição
		 * @return string
		 */
		public function getUri(){
			return $this->uri;
		}

		/**
		 * Metodo reponsavel por retorma os Headers da requisição
		 * @return array
		 */
		public function getHeaders(){
			return $this->headers;
		}

		/**
		 * Metodo reponsavel por retorma os QueryParams da requisição
		 * @return array
		 */
		public function getQueryParams(){
			return $this->queryParams;
		}

		/**
		 * Metodo reponsavel por retorma os PostVars da requisição
		 * @return array
		 */
		public function getPostVars(){
			return $this->postVars;
		}

	}