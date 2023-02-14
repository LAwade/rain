<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Product extends Model {

    public $name, $description, $unity, $split_payment = 1, $tax = 0, $test_period = 0, $id_category, $active = 1;
    public float $price;

    public function __construct()
    {
        $this->table = 'products';
    }

    private function verify(){
        try{
            $fields = [
                'name' => ['value' => $this->name, 'type' => 'string', 'min' => 3, 'max' => 150, 'nullable' => false],
                'description' => ['value' => $this->description, 'type' => 'string', 'min' => 3, 'max' => 150, 'nullable' => false],
                'price' => ['value' => $this->price, 'type' => 'int', 'nullable' => false],
                'unity' => ['value' => $this->unity, 'type' => 'int', 'nullable' => false],
                'split_payment' => ['value' => $this->split_payment, 'type' => 'int', 'nullable' => false],
                'tax' => ['value' => $this->tax, 'type' => 'int', 'nullable' => true],
                'test_period' => ['value' => $this->test_period, 'type' => 'int', 'nullable' => true],
                'id_category' => ['value' => $this->id_category, 'type' => 'int', 'nullable' => false],
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
    
    function find(int $id):? Product{
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }

    function findWithCategory(){
        $query = "SELECT *,a.id AS id, a.name AS name, a.description AS description, b.id AS id_category, b.name AS name_category , b.description AS description_category 
            FROM {$this->table} a 
            INNER JOIN categories b ON b.id = a.id_category
            WHERE a.active = 1 
            AND b.active = 1 
            ORDER BY b.name, a.unity, a.name";
        return $this->read($query)->fetchAll();
    }
    
    function findByIds(array $ids){
        $id = implode(",", $ids);
        $query = "SELECT * FROM {$this->table} WHERE id IN ($id);";
        return $this->read($query)->fetchAll();
    }
}
