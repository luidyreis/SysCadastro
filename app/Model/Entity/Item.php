<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Item
{
	
	/**
	 * Nome da table no banco de dados
	 * @var string
	 */
	private static $Table_name = 'Syscadastro_Item';

	/**
	 * ID do usuario
	 * @var integer
	 */
	public $Item_id;

	/**
	 * Nick do usuario
	 * @var string
	 */
	public $Item_name;

	/**
	 * E-mail do usuario
	 * @var string
	 */
	public $Item_email;

	/**
	 * Senha do usuario
	 * @var string
	 */
	public $Item_age;

  /**
	 * Senha do usuario
	 * @var string
	 */
	public $Item_course_name;

	/**
	 * Data e hora da criação da conta
	 * @var string
	 */
	public $Item_created;
  
  /**
	 * Data e hora da criação da conta
	 * @var string
	 */
	public $Item_update;


	/**
	 * Método responsavel por cadastrar a instancia atual do usuario no banco de dados
	 * @return boolean
	 */
	public function insert() {
		//Insere a instancia no banco
		$this->Item_id = (new Database(self::$Table_name))->insert([
			'Item_name'   			   => $this->Item_name,
		  'Item_email'			     => $this->Item_email,
			'Item_age' 		         => $this->Item_age,
			'Item_course_name' 	   => $this->Item_course_name,
			'Item_created'         => $this->Item_created,
      'Item_update'          => $this->Item_update
		]);
		return true;
	}

	/**
	 * Método responsavel por atualizar os dados do usuario no banco
	 * @return boolean
	 */
	public function update() {
		return (new Database(self::$Table_name))->update('Item_id =' . $this->Item_id, [
			'Item_name'   			   => $this->Item_name,
		  'Item_email'			     => $this->Item_email,
			'Item_age' 		         => $this->Item_age,
			'Item_course_name' 	   => $this->Item_course_name,
			'Item_created'         => $this->Item_created,
      'Item_update'          => $this->Item_update
		]);
	}

	/**
	 * Método responsavel por excluir os dados do usuario no banco
	 * @return boolean
	 */
	public function delete() {
		return (new Database(self::$Table_name))->delete('Item_id =' . $this->Item_id);
	}

	/**
	 * Método responsavel por retorma os usuarios do banco de dados
	 * @param  string $where
	 * @param  string $order
	 * @param  string $limit
	 * @param  string $field
	 * @return PDOStatement
	 */
	public static function getItems($where = null, $order = null, $limit = null, $fields = '*') {
		return (new Database(self::$Table_name))->select($where, $order, $limit, $fields);
	}

	/**
	 * Método responsavel por retorma um usuario com base em seu e-mail
	 * @param  string $email
	 * @return Item
	 */
	public static function getItemByEmail($email) {
		return self::getItems('Item_email = "'.$email.'"')->fetchObject(self::class);
	}

	/**
	 * Método responsavel por retorma um usuario com base em seu nick
	 * @param  string $nick
	 * @return Item
	 */
	public static function getItemByNick($nick){
		return self::getItems('Item_nick = "' . $nick . '"')->fetchObject(self::class);
	}

}
