<?php
	namespace App\Utils;

	class Functions {		
		/**
		 * Função responsavel por debugar o codigo fonte
		 * @param  array $params
		 * @param  boolean $die
		 * @return string
		 */		
		public static function dd($params = [], $die = true){
			echo '<pre>';
			print_r($params);
			echo '</pre>';
			if ($die) die();
		}
	}
	
