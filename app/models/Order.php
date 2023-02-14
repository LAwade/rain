<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Order extends Model{

    public $id_client, $id_status, $active = 1;

    public function __construct()
    {
        $this->table = 'orders';
    }

    private function verify(){
        try{
            $fields = [
                'id_client' => ['value' => $this->id_client, 'type' => 'int', 'nullable' => false],
                'id_status' => ['value' => $this->id_status, 'type' => 'int', 'nullable' => false],
                'active' => ['value' => $this->active, 'type' => 'int', 'nullable' => true]
            ];
    
            $f = new FieldsValidator($fields);
            return $f->to_array();
        }catch(Exception $e){
            $this->callback($e->getMessage());
        }
    }

    function save(int $id = null)
    {
        $data = $this->verify();
        if(empty($data)){
            return; 
        }
        
        if($id){
            return $this->update($data, ['id' => $id]);
        }
        return $this->insert($data);
    }
    
    function delete(int $id){
        return $this->remove($id);
    }
    
    function find(int $id):? Order{
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table};";
        return $this->read($query)->fetchAll();
    }

    function findByUser($user, $id_order = null){
        $data = ['id_client' => $user];
        $query = "SELECT a.id, id_status, name, id_client, active, a.created_at, a.updated_at 
            FROM  $this->table a 
            INNER JOIN status b ON a.id_status = b.id
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
            FROM $this->table a
            INNER JOIN itens b ON b.id_order = a.id
            INNER JOIN status c ON a.id_status = c.id
            INNER JOIN products d ON b.id_product = d.id
            WHERE id_client = :id_client ";

        if($id_order){
            $query .= " AND a.id = :id_order ";
            $data['id_order'] = $id_order;
        }
        return $this->read($query, $data)->fetchAll();
    }

    function findAllItens($id_order){
        $query = "SELECT a.id AS order_id, c.name AS status_name, d.name AS product_name, 
                e.name AS name_categorie, a.created_at AS created_order, 
                a.active as order_active, b.active as item_active, b.id as id_item, * 
            FROM $this->table a
            INNER JOIN itens b ON b.id_order = a.id
            INNER JOIN status c ON a.id_status = c.id
            INNER JOIN products d ON b.id_product = d.id
            INNER JOIN categories e ON d.id_category = e.id 
            WHERE id_order = :id_order;";
        return $this->read($query, ['id_order' => $id_order])->fetchAll();
    }
}
