<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Category extends Model {

    public $name, $description, $active = 1;

    public function __construct()
    {
        $this->table = 'categories';
    }

    private function verify(){
        try{
            $fields = [
                'name' => ['value' => ucwords($this->name), 'type' => 'string', 'min' => 3, 'max' => 50, 'nullable' => false],
                'description' => ['value' => $this->description, 'type' => 'string', 'min' => 3, 'max' => 150, 'nullable' => false],
                'active' => ['value' => $this->active, 'type' => 'int', 'nullable' => true]
            ];
    
            $f = new FieldsValidator($fields);
            return $f->to_array();
        } catch(Exception $e){
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
    
    function find(int $id): ?Category{
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }
}
