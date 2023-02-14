<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Permission extends Model {

    public $name, $value, $active = 1;

    public function __construct()
    {
        $this->table = 'permissions';
    }

    private function verify(){
        try{
            $fields = [
                'name' => ['value' => $this->name, 'type' => 'string', 'min' => 3, 'max' => 150, 'nullable' => false],
                'value' => ['value' => $this->value, 'type' => 'int', 'nullable' => false],
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
    
    function find(int $id):? Permission{
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }

    function findByName($name) {
        $query = "SELECT * FROM {$this->table} WHERE name = :name";
        return $this->read($query, ['name' => $name])->fetch();
    }

    function findPermissionByUser($iduser){
        $query = "SELECT c.name, c.value  
        FROM clients a 
        INNER JOIN permissions_client b ON a.id = b.id_client 
        INNER JOIN permissions c ON c.id = b.id_permission 
        WHERE a.id = :id 
        AND c.active = :active";
        return $this->read($query, ["id" => $iduser, 'active' => 1])->fetch();
    }

    function findPermissionUserPage($id, $page){
        $query = "SELECT * FROM {$this->table} a
        INNER JOIN pages b ON b.access_id_permission = a.id
        WHERE path = :path
        AND value_permission <= (SELECT value FROM permissions WHERE id = :id) 
        AND active = 1";

        return $this->read($query, ["path" => $id, "id" => $page])->fetch();
    }
}
