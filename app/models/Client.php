<?php

namespace app\models;
use app\core\Model;
use app\shared\FieldsValidator;
use Exception;

class Client extends Model{

    public $name;
    public $email;
    public $password;
    public $active = 1;

    function __construct()
    {
        $this->table = 'clients';
    }

    private function verify(){
        try{
            $fields = [
                'name' => ['value' => ucfirst($this->name), 'type' => 'string', 'min' => 5, 'max' => 250, 'nullable' => false],
                'email' => ['value' => $this->email, 'type' => 'string', 'min' => 8, 'max' => 250, 'nullable' => false],
                'password' => ['value' => $this->password, 'type' => 'password', 'min' => 6, 'max' => 200, 'nullable' => false],
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
    
    function find(int $id): ?Client {
        $query = "SELECT * FROM ". $this->table ." WHERE id = :id;";
        return  $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }

    function findByMail($mail){
        return $this->read("SELECT * FROM {$this->table} WHERE email = :email", ['email' => $mail])->fetch();
    }
}
