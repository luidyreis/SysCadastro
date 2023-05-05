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
	 * ID do item
	 * @var integer
	 */
	public $Item_id;

	/**
	 * Nick do item
	 * @var string
	 */
	public $Item_name;

	/**
	 * E-mail do item
	 * @var string
	 */
	public $Item_email;

	/**
	 * Senha do item
	 * @var string
	 */
	public $Item_age;

  /**
	 * Senha do item
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
	 * Método responsavel por cadastrar a instancia atual no banco de dados
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
	 * Método responsavel por atualizar os dados no banco
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
	 * Método responsavel por excluir os dados no banco
	 * @return boolean
	 */
	public function delete() {
		return (new Database(self::$Table_name))->delete('Item_id =' . $this->Item_id);
	}

	/**
	 * Método responsavel por retorma os banco de dados
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
	 * Método responsavel por retorma com base em seu id
	 * @param  string $id
	 * @return Item
	 */
	public static function getItemById($id) {
		return self::getItems('Item_Id = "'.$id.'"')->fetchObject(self::class);
	}
}
