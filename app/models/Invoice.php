<?php

namespace app\models;

use Exception;
use app\core\Model;
use app\shared\FieldsValidator;

class Invoice extends Model{

    public $id_order, $id_status, $payment_date, $due_date, $amount, $active;

    public function __construct()
    {
        $this->table = 'invoices';
    }

    private function verify(){
        try{
            $fields = [
                'id_order' => ['value' => $this->id_order, 'type' => 'int', 'nullable' => false],
                'id_status' => ['value' => $this->id_status, 'type' => 'int', 'nullable' => false],
                'amount' => ['value' => $this->amount, 'type' => 'int', 'nullable' => false],
                'payment_date' => ['value' => $this->payment_date, 'type' => 'string', 'nullable' => false],
                'due_date' => ['value' => $this->due_date, 'type' => 'string', 'nullable' => false], 
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
    
    function find(int $id): ?Invoice {
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->instance($this->read($query, ['id' => $id])->fetch(), $this);
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }

    function findByOrder(int $order){
        $query = "SELECT * FROM invoices WHERE id_order = :id_order; ";
        return $this->read($query, ['id_order' => $order])->fetch();
    }

    function findByUser(int $id){
        $query = 'SELECT a.id, id_order, payment_date, due_date, amount, a.id_status, d.name, a.active, a.updated_at, a.created_at
            FROM invoices a 
            INNER JOIN orders b ON a.id_order = b.id 
            INNER JOIN clients c ON b.id_client = c.id 
            INNER JOIN status d ON a.id_status = d.id 
            WHERE id_client = :id 
            ORDER BY id DESC';
        return $this->read($query, ['id' => $id])->fetchAll();
    }
}