<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Page extends Model {

    public $name, $path, $id_menu, $access_id_permission, $active = 1;

    public function __construct()
    {
        $this->table = 'pages';
    }

    private function verify(){
        try{
            $fields = [
                'name' => ['value' => $this->name, 'type' => 'string', 'min' => 3, 'max' => 250, 'nullable' => false],
                'path' => ['value' => $this->path, 'type' => 'string', 'min' => 3, 'max' => 250, 'nullable' => false],
                'id_menu' => ['value' => $this->id_menu, 'type' => 'int', 'nullable' => false],
                'access_id_permission' => ['value' => $this->access_id_permission, 'type' => 'int', 'nullable' => false],
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
    
    function find(int $id): ?Page {
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }

    public function findStruture($value) {
        $query = "SELECT * FROM {$this->table} a "
                . "INNER JOIN permissions b ON b.id = a.access_id_permission "
                . "INNER JOIN menus c ON c.id_menu = a.id_menu "
                . "ORDER BY id_page";
        return $this->read($query)->fetchAll();
    }

    public function findAllConfig() {
        $query = "SELECT a.id, path, a.name, b.name as access, a.active 
                FROM {$this->table} a 
                INNER JOIN permissions b ON b.id = a.access_id_permission 
                INNER JOIN menus c ON c.id = a.id_menu 
                ORDER BY a.id";
        return $this->read($query)->fetchAll();
    }
}
