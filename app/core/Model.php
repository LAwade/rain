<?php

namespace app\core;

use app\core\Connect;
use PDOException;
use PDO;
use PDOStatement;

abstract class Model
{

    protected $callback;
    protected $table;

    protected function instance(object $rows, $obj)
    {
        foreach ($rows as $k => $v) {
            $obj->$k = $v;
        }
        return $obj;
    }

    public function begin(): ?int
    {
        try {
            Connect::getInstance()->beginTransaction();
            return 1;
        } catch (PDOException $ex) {
            //$this->callback = "Error: " . $ex->getMessage();
            logger('PDOExcep')->error('PDOException: ' . $ex->getMessage(), debug_backtrace());
            return null;
        }
    }

    public function commit(): ?int
    {
        try {
            Connect::getInstance()->commit();
            return 1;
        } catch (PDOException $ex) {
            //$this->callback = "Error: " . $ex->getMessage();
            logger('PDOExcep')->error('PDOException: ' . $ex->getMessage(), debug_backtrace());
            return null;
        }
    }

    public function rollback(): ?int
    {
        try {
            Connect::getInstance()->rollBack();
            return 1;
        } catch (PDOException $ex) {
            //$this->callback = "Error: " . $ex->getMessage();
            logger('PDOExcep')->error('PDOException: ' . $ex->getMessage(), debug_backtrace());
            return null;
        }
    }

    protected function insert(array $data): ?int
    {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connect::getInstance()->prepare("INSERT INTO ". $this->table ." ({$columns}) VALUES({$values})");
            foreach ($data as $key => $value) {
                if (is_string($value)) {
                    $stmt->bindValue(":{$key}", $value, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue(":{$key}", $value, PDO::PARAM_INT);
                }
            }
            $stmt->execute();
            return Connect::getInstance()->lastInsertId();
        } catch (PDOException $ex) {
            //$this->callback = "Error: " . $ex->getMessage();
            logger('PDOExcep')->error('PDOException: ' . $ex->getMessage(), debug_backtrace());
            return null;
        }
    }

    protected function read(string $query, $data = null): ?PDOStatement
    {
        try {
            $stmt = Connect::getInstance()->prepare($query);
            if ($data) {
                foreach ($data as $key => $value) {
                    if (!$value || $value == "null") {
                        $value = null;
                    }
                    $stmt->bindValue(":{$key}", $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
                }
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            //$this->callback = "Error: " . $ex->getMessage();
            logger('PDOExcep')->error('PDOException: ' . $ex->getMessage(), debug_backtrace());
            return null;
        }
    }

    protected function remove(int $id): ?int
    {
        try {
            $stmt = Connect::getInstance()->prepare("DELETE FROM ". $this->table ." WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return ($stmt->rowCount() ?? 1);
        } catch (PDOException $ex) {
            //$this->callback = "Error: " . $ex->getMessage();
            logger('PDOExcep')->error('PDOException: ' . $ex->getMessage(), debug_backtrace());
            return null;
        }
    }

    protected function update(array $set, array $terms): ?int
    {
        try {

            $set['updated_at'] = date('Y-m-d H:i:s');

            $buildstmt = function ($data) {
                $dataset = [];
                foreach ($data as $key => $val) {
                    $dataset[] = "{$key} = :{$key}";
                }
                $set = implode(", ", $dataset);
                return $set;
            };

            $params = $buildstmt($set);
            $where = $buildstmt($terms);
            $stmt = Connect::getInstance()->prepare("UPDATE ". $this->table ." SET {$params} WHERE {$where}");
            $binds = array_merge($set, $terms);
            foreach ($binds as $key => $value) {
                if (is_string($value)) {
                    $stmt->bindValue(":{$key}", $value, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue(":{$key}", $value, PDO::PARAM_INT);
                }
            }

            $stmt->execute();
            return ($stmt->rowCount() ?? 1);
        } catch (PDOException $ex) {
            //$this->callback = "Error: " . $ex->getMessage();
            logger('PDOExcep')->error('PDOException: ' . $ex->getMessage(), debug_backtrace());
            return null;
        }
    }

    public function callback($callback = null): ?string
    {
        if ($callback) {
            $this->callback = $callback;
            return null;
        }
        $callback = $this->callback;
        unset($this->callback);
        return $callback;
    }
}
