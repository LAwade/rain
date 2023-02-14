<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Payment extends Model {

    public $id_invoice, $id_status, $received, $amount, $id_bank, $code_reference, $external_id, $logs, $active = 1;

    public function __construct()
    {
        $this->table = 'payments';
    }

    private function verify(){
        try{
            $fields = [
                'id_invoice' => ['value' => $this->id_invoice, 'type' => 'int', 'nullable' => false],
                'id_bank' => ['value' => $this->id_bank, 'type' => 'int', 'nullable' => false],
                'id_status' => ['value' => $this->id_status, 'type' => 'int', 'nullable' => false],
                'received' => ['value' => $this->received, 'type' => 'int', 'nullable' => false],
                'amount' => ['value' => $this->active, 'type' => 'int', 'nullable' => false],
                'code_reference' => ['value' => $this->code_reference, 'type' => 'string', 'max' => 255, 'nullable' => true],
                'external_id' => ['value' => $this->code_reference, 'type' => 'string', 'max' => 255, 'nullable' => true],
                'logs' => ['value' => $this->logs, 'type' => 'string', 'nullable' => true]
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
    
    function find(int $id): ?Payment{
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }
}
