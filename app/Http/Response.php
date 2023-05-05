<?php
	namespace App\Http;

	class Response {
		
		/**
		 * Codigo do status do HTTP
		 * @var integer
		 */
		private $httpCode = 200;

		/**
		 * Cabeçalho do response
		 * @var array
		 */
		private $headers = [];

		/**
		 * Tipo de conteudo que esta sendo retornado
		 * @var string
		 */
		private $contentType = 'text/html';

		/**
		 * Conteudo do responser
		 * @var mixed
		 */
		private $content;
		
		/**
		 * Metodo responsavel por inicia a classe e definir os valores
		 * @param integer $httpCode
		 * @param mixed $content
		 * @param mixed $contentType
		 */
		public function __construct($httpCode,$content,$contentType = 'text/html'){
			$this->httpCode = $httpCode;
			$this->content = $content;
			$this->setContentType($contentType);
		}
		
		/**
		 * Metodo responsavel por alterar o ContentType do response
		 * @param string $contentType
		 */
		public function setContentType($contentType){
			$this->contentType = $contentType;		
			$this->addHeader('Access-Control-Allow-Origin', '*');
			$this->addHeader('Access-Control-Allow-Methods', 'GET, POST');
			$this->addHeader('Access-Control-Allow-Headers', 'token, Content-Type');
			$this->addHeader('Content-Type', $contentType);
		}

		/**
		 * Metodo responsavel por adicionar o header do reponse
		 * @param string $key
		 * @param string $values
		 */
		public function addHeader($key, $values){
			$this->headers[$key] = $values;
		}
				
		/**
		 * Metodo responsavel por enviar os headers para o navegador
		 */
		private function sendHeaders(){
			//Defini status
			http_response_code($this->httpCode);

			//Enviar todos os headers
			foreach($this->headers as $key=>$values){
				header($key.': '.$values);
			}
		}

		/**
		 * Metodo responsavel por minificar o html para o site ter um ganho consideravel en velocidade
		 */
		private function minify_html($html){
			$search = array(
				'/(\n|^)(\x20+|\t)/',
				'/(\n|^)\/\/(.*?)(\n|$)/',
				'/\n/',
				'/\<\!--.*?-->/',
				'/(\x20+|\t)/', # Delete multispace (Without \n)
				'/\>\s+\</', # strip whitespaces between tags
				'/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
				'/=\s+(\"|\')/'); # strip whitespaces between = "'

			$replace = array(
				"\n",
				"\n",
				" ",
				"",
				" ",
				"><",
				"$1>",
				"=$1");

				$html = preg_replace($search,$replace,$html);
				return $html;
		}

		/**
		 * Metodo responsavel por enviar a responsa para o usuario
		 */
		public function sendResponse(){
			//Envia os headers
			$this->sendHeaders();

			//Imprine o conteudo
			switch ($this->contentType) {
				case 'text/html':
					echo self::minify_html($this->content);
					exit();
				case 'application/json':
					echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
					exit();
			}
		}

	}