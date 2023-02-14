<?php

namespace app\repository;

use app\core\Repository;
use app\models\Category;
use app\models\Product;

class ProductRepository extends Repository{

    function __construct()
    {
        $this->table();
    }

    private function table(){
        $this->table = Product::TABLE;
    }
    
    function create(Product $data, ?int $id = null)
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
        $query = "SELECT * FROM {$this->table}";
        return $this->read($query)->fetchAll();
    }

    function findWithCategory(){
        $query = "SELECT *,a.id AS id, a.name AS name, a.description AS description, b.id AS id_category, b.name AS name_category , b.description AS description_category 
            FROM {$this->table} a 
            INNER JOIN " . Category::TABLE . " b ON b.id = a.id_category
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