<?php

namespace app\shared;

use app\models\Item;
use app\models\Order;
use app\repository\OrderRepository;
use app\repository\CategoryRepository;
use app\repository\ItemRepository;

class OrderShop {

    private $order;
    private $item;

    const CATEGORIES = ['teamspeak', 'tibiatsbot'];

    function __construct(
        private string $id
    )   
    {
        $this->order = new OrderRepository;
        $this->item = new ItemRepository;
    }

    function verifyOrder(){
        $itens = $this->order->findAllItens($this->id);
        if($itens){
            foreach($itens as $i){
                if(!$i->item_active){
                    $class = __NAMESPACE__ . "\\" . __CLASS__;
                    $func = strtolower($i->item_active);
                    if(method_exists($class, $func)){
                        call_user_func_array(array($class, $func), []);
                    }
                }

                $item = $this->item->find($i->id_item);
                $item->active = 1;
                $this->item->create($item, $this->id);

                $order = new Order(
                    $i->id_cliente,
                    $i->id_status,
                    1
                );
                $this->order->create($order, $this->id);
            }
        }
    }

    private function teamspeak(){
        
    }

    private function tibiatsbot(){
        
    }

}

?>