<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Bank extends Model {

    public $name, $description, $url, $url_notification, $key, $extra_code, $active = 1;

    public function __construct()
    {
        $this->table = 'banks';
    }

    private function verify(){
        try{
            $fields = [
                'name' => ['value' => ucwords($this->name), 'type' => 'string', 'min' => 5, 'max' => 150, 'nullable' => false],
                'description' => ['value' => $this->description, 'type' => 'string', 'max' => 150, 'nullable' => true],
                'url' => ['value' => $this->url, 'type' => 'string', 'max' => 255, 'nullable' => true],
                'url_notification' => ['value' => $this->url_notification, 'type' => 'string', 'max' => 255, 'nullable' => true],
                'key' => ['value' => $this->key, 'type' => 'string', 'max' => 255, 'nullable' => true],
                'extra_code' => ['value' => $this->extra_code, 'type' => 'string', 'max' => 255, 'nullable' => true],
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
    
    function find(int $id): ?Bank{
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY 1";
        return $this->read($query)->fetchAll();
    }

    function findLikeByName($name){
        $query = "SELECT * FROM {$this->table} WHERE name ILIKE '%$name%';";
        return $this->read($query)->fetch();
    }
}
