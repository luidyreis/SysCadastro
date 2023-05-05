<?php
	namespace App\Utils;

	class View {
		
		/**
		 * Variaveis padrões
		 * @var array
		 */
		private static $vars = [];


		/**
		 * Metodo responsavel por definir os dados iniciaa da classe
		 * @param  array $vars
		 */
		public static function init($vars=[]){
			self::$vars = $vars;
		}

		/**
		 * Método responsalve por retorma o conteudo de uma view
		 * @param string $view
		 * @return string
		 */
		private static function getContentView($view){
			$file = __DIR__.'/../../resources/view/'.$view.'.html';
			return file_exists($file) ? file_get_contents($file) : '';
		}

		/**
		 * Método responsavel por o conteudo renderizado de uma view
		 * @param string $view
		 * @param array $vars (string/numeric)
		 * @return string
		 */
		public static function render($view, $vars = []) {
			//Conteudo da view
			$contentView = self::getContentView($view);

			//Merge de variaves do view
			$vars = array_merge(self::$vars,$vars);

			//Chave dos array de variaveis
			$keys = array_keys($vars);
			$keys = array_map(function($item){
				return '{{'.$item.'}}';
			},$keys);

			//Retorma o conteudo renderizado
			return str_replace($keys,array_values($vars),$contentView);
		}

		/**
		 * Método responsavel por renderizar os assets
		 * @param string $view
		 * @param array $vars (string/numeric)
		 * @return string
		 */
		public static function assets($view) {
			//Adicionar o caminho absoluto
			$file = __DIR__. '/../../resources/view/assets/'.$view.'/assets.html';
			return file_exists($file) ? self::render('assets/'.$view .'/assets') : null;
		}

		/**
		 * Método responsavel por renderizar os scripts
		 * @param string $view
		 * @param array $vars (string/numeric)
		 * @return string
		 */
		public static function scripts($view) {
			//Adicionar o caminho absoluto
			$file = __DIR__ . '/../../resources/view/assets/'.$view.'/scripts.html';
			return file_exists($file) ? self::render('assets/'.$view.'/scripts') : null;
		}
	}