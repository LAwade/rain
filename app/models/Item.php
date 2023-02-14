<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Item extends Model{

    public $id_order, $id_product, $quantity, $active = 1;

    public function __construct()
    {
        $this->table = 'itens';
    }

    private function verify(){
        try{
            $fields = [
                'id_order' => ['value' => $this->id_order, 'type' => 'int', 'nullable' => false],
                'id_product' => ['value' => $this->id_product, 'type' => 'int', 'nullable' => false],
                'quantity' => ['value' => $this->quantity, 'type' => 'int', 'nullable' => false],
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
    
    function find(int $id):? Item {
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }
}
