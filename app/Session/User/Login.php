<?php

namespace App\Session\User;

class Login
{

	/**
	 * Método responsavel por inicia a sessão
	 */
	private static function init()
	{
		//Verifica se a sessão não esta ativa
		if (session_status() != PHP_SESSION_ACTIVE) {
			session_start();
		}
	}

	/**
	 * Método responsavel por criar o login do usuario
	 * @param  User $obUser
	 * @return boolean
	 */
	public static function login($obUser)
	{
		//Inicia a sessão
		self::init();

		$_SESSION['user'] = [
			'id'    => $obUser->User_id,
		];

		return true;
		
	}

	/**
	 * Método responsalve por verifica se o usuario esta logado
	 * @return boolean
	 */
	public static function isLogged(){
		//Inicia a sessão
		self::init();

		//Retorna true ou false
		return isset($_SESSION['user']['id']) || isset($_SESSION['admin']['id']) ;
	}
	
	/**
	 * Método reposavel por verifica se o usuario na verdade e um Adminstrador
	 * @return boolean
	 */
	public static function isAdm() {
		//Inicia  a sessão
		self::init();

		//Retorna true ou false
		return isset($_SESSION['admin']['id']);
	}
	
	/**
	 * Método reponsavel por retorna o ID do usuario ou adminstrador
	 * @return string
	 */
	public static function getId() {
		//Inicia a sessão
		self::init();

		//Retorna o ID do usuario ou do adminstrador, se não achar um dos dois destroi todas as session do navegador por segurança
		if (isset($_SESSION['admin']['id'])) {
			$id = $_SESSION['admin']['id'];
		}else if (isset($_SESSION['user']['id'])){
			$id = $_SESSION['user']['id'];
		}else {
			self::logout();
		}

		//retorna o Id
		return $id;
	}

	/**
	 * Método responsavel por deslocgar usuario
	 * @return boolean
	 */
	public static function logout()
	{
		//Inicia a sessão
		self::init();

		//Desloga o usuario, destroi a session do usuario ou adminstrador
		if(isset($_SESSION['admin']['id']) || $_SESSION['user']['id']) {
			unset($_SESSION['user']);
		}

		//Restorna true se unset acontece normal
		return true;
	}
}
