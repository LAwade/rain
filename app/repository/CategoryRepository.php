<?php

namespace app\repository;

use app\core\Repository;
use app\models\Category;

class CategoryRepository extends Repository{

    function __construct()
    {
        $this->table();
    }

    private function table(){
        $this->table = Category::TABLE;
    }
    
    function create(Category $data, ?int $id = null)
    {
        if($id){
            return $this->update($data->toArray(), ['id' => $id]);
        }
        return $this->insert($data->toArray(), $id);
    }
    
    function delete(int $id){
        return $this->remove($id);
    }
    
    function find(int $id){
        $query = "SELECT * FROM {$this->table} WHERE id = :id;";
        return $this->read($query, ['id' => $id])->fetch();
    }
    
    function findAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        return $this->read($query)->fetchAll();
    }

}