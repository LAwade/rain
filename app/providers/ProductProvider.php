<?php

namespace app\providers;

use app\interface\IProduct;
use app\models\Item;
use Exception;

/**
 * PRODUCT PROVIDER
 * 
 * RESPONSAVEL PARA IDENTIFICAR O TIPO/CATEGORIA DO PRODUTO PARA CRIAR UMA ATIVAÇÃO DO SERVICO
 * 
 * TEAMSPEAK:
 *  - CRIA UM REGISTRO NO BANCO DE DADOS PARA ATIVAR MANUALMENTE, NO CASO O CLIENTE PRECISA CONFIGURAR O TS PRIMEIRO PARA SER REGISTRADO
 * 
 * TS3BOT:
 *  - 
 */
class ProductProvider implements IProduct {

    public function teamspeak($data){
    }

    public function tibiatsbot($data){
    }

   
}

?>

