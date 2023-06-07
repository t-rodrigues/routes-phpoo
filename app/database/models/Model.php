<?php

namespace app\database\models;

use app\database\Connection;
use app\database\Filters;
use PDO;
use PDOException;

abstract class Model
{
    private string $fields = '*';
    private ?Filters $filters = null;
    protected string $table;
    private string $pagination = '';

    public function setFields(string $fields): void
    {
        $this->fields = $fields;
    }

    public function setFilters(Filters $filters): void
    {
        $this->filters = $filters;
    }

    public function setPagination(Pagination $pagination): void
    {
        $pagination->setTotalItems($this->count());
        $this->pagination = $pagination->dump();
    }

    public function create(array $data): bool
    {
        try {
            $sql = "insert into {$this->table} (";
            $sql .= implode(', ', array_keys($data)) . ")";
            $sql .= ' values (:';
            $sql .= implode(', :', array_keys($data)) . ")";
            $connection = Connection::connect();
            $prepare = $connection->prepare($sql);

            return $prepare->execute($data);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function update(string $field, string|int $fieldValue, array $data): bool
    {
        try {
            $sql = "update {$this->table} set ";
            foreach ($data as $key => $value) {
                $sql .= "{$key} = :{$key}, ";
            }
            $sql = rtrim($sql, ', ');
            $sql .= " where {$field} = :{$field}";
            $connection = Connection::connect();
            $prepare = $connection->prepare($sql);

            return $prepare->execute([...$data, $field => $fieldValue]);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function fetchAll(): array
    {
        try {
            $sql = "select {$this->fields} from {$this->table} {$this->filters?->dump()} {$this->pagination}";
            $connection = Connection::connect();
            $prepare = $connection->prepare($sql);
            $prepare->execute($this->filters ? $this->filters->getBind() : []);

            return $prepare->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function findBy(string $field = '', string $value = '')
    {
        try {
            $sql = (!empty($this->filters))
                ? "select {$this->fields} from {$this->table} {$this->filters?->dump()}"
                : "select {$this->fields} from {$this->table} where {$field} = :{$field}";

            $connection = Connection::connect();
            $prepare = $connection->prepare($sql);
            $prepare->execute($this->filters ? $this->filters->getBind() : [$field => $value]);

            return $prepare->fetchObject();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function first(string $field = 'id', string $order = 'asc')
    {
        try {
            $sql = "select {$this->fields} from {$this->table} order by {$field} {$order}";
            $connection = Connection::connect();
            $query = $connection->query($sql);

            return $query->fetchObject();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function delete(string $field = '', string|int $value = ''): int
    {
        try {
            $sql = (!empty($this->filters))
                ? "delete from {$this->table} {$this->filters?->dump()}"
                : "delete from {$this->table} where {$field} = :{$field}";

            $connection = Connection::connect();
            $prepare = $connection->prepare($sql);
            $prepare->execute(empty($this->filters) ? [$field => $value] : $this->filters->getBind());

            return $prepare->rowCount();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function count(): int
    {
        try {
            $sql = "select {$this->fields} from {$this->table} {$this->filters?->dump()}";
            $connection = Connection::connect();
            $prepare = $connection->prepare($sql);
            $prepare->execute($this->filters ? $this->filters->getBind() : []);

            return $prepare->rowCount();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
}
