<?php

namespace app\database\models;

use app\database\Connection;
use app\database\Filters;
use PDO;
use PDOException;

abstract class Model
{
    private string $fields = '*';
    private string $filters = '';
    protected string $table;

    public function setFields(string $fields): void
    {
        $this->fields = $fields;
    }

    public function setFilters(Filters $filters): void
    {
        $this->filters = $filters->dump();
    }

    public function fetchAll()
    {
        try {
            $sql = "select {$this->fields} from {$this->table} {$this->filters}";
            $connection = Connection::connect();
            $query = $connection->query($sql);

            return $query->fetchAll(PDO::FETCH_CLASS, get_called_class());
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function findBy(string $field = '', string $value = '')
    {
        try {
            $sql = (!empty($this->filters))
                ? "select {$this->fields} from {$this->table} {$this->filters}"
                : "select {$this->fields} from {$this->table} where {$field} = :{$field}";

            $connection = Connection::connect();
            $prepare = $connection->prepare($sql);
            $prepare->execute(empty($this->filters) ? [$field => $value] : []);

            return $prepare->fetchObject(get_called_class());
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function delete(string $field = '', string|int $value = '')
    {
        try {
            $sql = (!empty($this->filters))
                ? "delete from {$this->table} {$this->filters}"
                : "delete from {$this->table} where {$field} = :{$field}";

            $connection = Connection::connect();
            $prepare = $connection->prepare($sql);
            $prepare->execute(empty($this->filters) ? [$field => $value] : []);

            return $prepare->rowCount();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
}
