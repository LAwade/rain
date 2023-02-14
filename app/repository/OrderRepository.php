<?php

namespace app\repository;

use app\core\Repository;
use app\models\Item;
use app\models\Order;
use app\models\Product;
use app\models\Status;

class OrderRepository extends Repository{

    function __construct()
    {
        $this->table();
    }

    private function table(){
        $this->table = Order::TABLE;
    }
    
    function create(Order $data, ?int $id = null)
    {
        if($id){
            return $this->update($data->toArray(), ['id' => $id]);
        }
        return $this->insert($data->toArray(), $id);
    }
    
    function delete(int $id){
        return $this->remove($id);
    }
    
    function find(int $id){
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->read($query, ['id' => $id])->fetch();
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }

    function findByUser($user, $id_order = null){
        $data = ['id_client' => $user];
        $query = "SELECT a.id, id_status, name, id_client, active, a.created_at, a.updated_at FROM " . Order::TABLE . " a 
            INNER JOIN " .Status::TABLE. " b ON a.id_status = b.id
            WHERE id_client = :id_client ";
        if($id_order){
            $query .= " AND a.id = :id_order ";
            $data['id_order'] = $id_order;
        }
        $query .= " ORDER BY a.id ";
        return $this->read($query, $data)->fetchAll();
    }

    function findItensByUser($id_client, $id_order = null){
        $data = ['id_client' =>  $id_client];

        $query = "SELECT a.id AS order_id, c.name AS status_name, d.name AS product_name, a.created_at AS created_order, * 
            FROM " . Order::TABLE . " a
            INNER JOIN ". Item::TABLE ." b ON b.id_order = a.id
            INNER JOIN ". Status::TABLE ." c ON a.id_status = c.id
            INNER JOIN ". Product::TABLE ." d ON b.id_product = d.id
            WHERE id_client = :id_user ";

        if($id_order){
            $query .= " AND a.id = :id_order ";
            $data['id_order'] = $id_order;
        }
        return $this->read($query, $data)->fetchAll();
    }

    function findAllItens($id_order){
        $query = "SELECT a.id AS order_id, c.name AS status_name, d.name AS product_name, a.created_at AS created_order, 
                a.active as order_active, b.active as item_active, b.id as id_item, * 
            FROM " . Order::TABLE . " a
            INNER JOIN ". Item::TABLE ." b ON b.id_order = a.id
            INNER JOIN ". Status::TABLE ." c ON a.id_status = c.id
            INNER JOIN ". Product::TABLE ." d ON b.id_product = d.id
            WHERE id_order = :id_order;";
        return $this->read($query, ['id_order' => $id_order])->fetchAll();
    }
}