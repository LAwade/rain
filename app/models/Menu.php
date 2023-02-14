<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Menu extends Model{

    public $name, $icon, $position, $active = 1;

    public function __construct()
    {
        $this->table = 'menus';
    }

    private function verify(){
        try{
            $fields = [
                'name' => ['value' => $this->name, 'type' => 'string', 'min' => 3, 'max' => 50, 'nullable' => false],
                'icon' => ['value' => $this->icon, 'type' => 'string', 'min' => 3, 'max' => 250, 'nullable' => false],
                'position' => ['value' => $this->position, 'type' => 'int', 'nullable' => false],
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
    
    function find(int $id):? Menu{
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }

    public function findStruture($value) {
        $query = "SELECT a.name, position, icon, b.name as name_page, path, split_part(path, '/', 1) AS menu_heading 
                FROM {$this->table} a 
                INNER JOIN pages b ON b.id_menu = a.id
                INNER JOIN permissions d ON d.id = b.access_id_permission
                WHERE value <= :value
                AND a.active = :active
                AND b.active = :active
                AND d.active = :active
                ORDER BY position, b.name, a.created_at";
        return $this->read($query, ['value' => $value, 'active' => 1])->fetchAll();
    }
}
