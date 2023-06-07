<?php

namespace app\database;

class Filters
{
    private array $filters = [];
    private array $binds = [];

    public function where(string $field, string $operator, mixed $value, string $logic = ''): void
    {
        $formatter = '';

        if (is_array($value)) {
            $formatter = "('" . implode("', '", $value) . "')";
        } else if (is_string($value)) {
            $formatter = "'{$value}'";
        } else if (is_bool($value)) {
            $formatter = $value ? 1 : 0;
        } else {
            $formatter = $value;
        }

        $value = strip_tags($formatter);
        $fieldBind = str_contains($field, '.') ? str_replace('.', '', $field) : $field;
        $this->filters['where'][] = "{$field} {$operator} :{$fieldBind} {$logic}";
        $this->binds[$fieldBind] = $value;
    }

    public function limit(int $limit)
    {
        $this->filters['limit'] = " limit {$limit}";
    }

    public function orderBy(string $field, string $order = 'ASC'): void
    {
        $this->filters['orderBy'] = " order by {$field} {$order}";
    }

    public function join(string $foreignTable, string $joinTable1, string $operator, string $joinTable2, string $joinType = 'inner join'): void
    {
        $this->filters['join'][] = "{$joinType} {$foreignTable} on {$joinTable1} {$operator} {$joinTable2}";
    }

    public function dump(): string
    {
        $filter = !empty($this->filters['join']) ? implode(' ', $this->filters['join']) : '';
        $filter .= !empty($this->filters['where']) ? ' where ' . implode(' ', $this->filters['where']) : '';
        $filter .= $this->filters['orderBy'] ?? '';
        $filter .= $this->filters['limit'] ?? '';
        return trim($filter);
    }

    public function getBind()
    {
        return $this->binds;
    }
}
