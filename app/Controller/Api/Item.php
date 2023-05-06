<?php

namespace App\Controller\Api;

use \App\Model\Entity\Item as EntityItem;

class Item extends Api{

	/**
	 * Método responsavel por registrar um novo usuarias via api
	 * @param mixed $request
	 * @return void
	 */
	public static function setItem($request) {

		//Captura os dados enviados pelo formulario
		$postVars = $request->getPostVars();
		$name = $postVars['name'] ?? '';
		$age = $postVars['age'] ?? '';
		$courseName = $postVars['course_name'] ?? '';
		$email = $postVars['email'] ?? '';

		// Verifica se os campos não estão limpos
		if (empty($name) || empty($age) || empty($courseName) || empty($email)) {
			$retorno = array('codigo' => 1, 'mensagem' => 'Preencha todos os campos');
			echo json_encode($retorno);
			exit();
		}

    //Verifica se o campo e-mail esta valido
    if (!filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
      $retorno = array('codigo' => 1, 'mensagem' => 'E-mail invalido');
			echo json_encode($retorno);
			exit();
    }

		//Nova instancia de usuario e cadastra ela no banco de dados
		$obItem = new EntityItem;
		$obItem->Item_name  = $name;
		$obItem->Item_email = $email;
		$obItem->Item_age = $age;
		$obItem->Item_course_name = $courseName;
    $obItem->Item_created = date("Y-m-d H:i:s");

		if ($obItem->insert()) {
			$retorno = array('codigo' => 2, 'mensagem' => 'Item cadastrado com sucesso');
			echo json_encode($retorno);
			exit();
		} 
	}

  // Função responsavel por realiza a busca dos dados e retorma em forma de json
  public static function getItems() {

    $items = [];

    $result = EntityItem::getItems();
    while($obItem = $result->fetchObject(EntityItem::class)) {
      $items[] = [
        'Item_id'              => $obItem->Item_id,
        'Item_name'   			   => $obItem->Item_name,
		    'Item_email'			     => $obItem->Item_email,
			  'Item_age' 		         => $obItem->Item_age,
			  'Item_course_name' 	   => $obItem->Item_course_name,
			  'Item_created'         => $obItem->Item_created,
        'Item_update'         => $obItem->Item_update,
      ];
    }

    $retorno = array('Items' => $items);
    echo json_encode($retorno);
    exit();
  }

  public static function deletItem($request) {
    $postVars = $request->getPostVars();
		$id = $postVars['itemId'] ?? '';

    //Verifica se o campo esta vazio
    if(empty($id)) {
      $retorno = array('codigo' => 1, 'mensagem' => 'Campo ID vazio');
			echo json_encode($retorno);
			exit();
    }

    $result = EntityItem::getItemById($id);

    //Verifica se a instacia e realmente um instancia do item no banco de dados
    if($result instanceof EntityItem) {
      //Realiza o delete do item ao banco
      $result = $result->delete();
      //Verifica se houver sucesso
      if($result) {
        $retorno = array('codigo' => 1, 'mensagem' => 'Item deletado com sucesso');
        echo json_encode($retorno);
        exit();
      } else {
        $retorno = array('codigo' => 2, 'mensagem' => 'Ocorreu um error relate para o admistrador do systema');
        echo json_encode($retorno);
        exit();
      }
    } else {
      $retorno = array('codigo' => 2, 'mensagem' => 'ID não encontrado');
      echo json_encode($retorno);
      exit();
    }
  }
}
