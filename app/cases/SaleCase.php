<?php

namespace app\cases;

use app\interface\IProduct;
use app\interface\ISale;
use Exception;

/**
 * PRODUCT PROVIDER
 * 
 * RESPONSAVEL PARA IDENTIFICAR O TIPO DE PAGAMENTO ORDER/INVOICE
 * 
 */
class SaleCase
{

    private ISale $sale;
    private IProduct $product;

    public function __construct(ISale $sale, IProduct $product)
    {
        $this->sale = $sale;
        $this->product = $product;
    }

    public function handle(string $type, int $id, array $payment)
    {
        try {
            if (strtoupper($type) == 'ORDER') {
                $data = $this->sale->order($id, $payment);
            } else {
                $data = $this->sale->invoice($id, $payment);
            }

            if(!$data){
                throw new Exception('Não foi possível atualizar as informações do pedido!');
            }

            foreach ($data as $v) {
                if (strtolower($v->name_categorie) == 'teamspeak') {
                    $this->product->teamspeak($v);
                } else {
                    $this->product->tibiatsbot($v);
                }
            }
        } catch (Exception $e) {
            logger('salescase')->error($e->getMessage());
        }
    }

}
