<?php
/**
 * User: utku
 * Date: 10.09.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class Mysql extends \PDO {

    private $sql, $tableName, $where, $join, $orderBy, $groupBy, $limit;

    public function __construct($host, $dbName, $username, $password, $charset = 'utf8') {
        parent::__construct('mysql:host=' . $host . ';dbname=' . $dbName, $username, $password);
        $this->query('SET CHARACTER SET ' . $charset);
        $this->query('SET NAMES ' . $charset);
    }

    public function sql($sqlStr) {
        $this->sql = $sqlStr;
    }

    public function runSql() {
        $this->prepare($this->sql);
    }

    public function getSqlString() {
        return $this->sql;
    }

    public function from($tableName) {
        $this->sql = 'SELECT * FROM `' . $tableName . '`';
        $this->tableName = $tableName;
        return $this;
    }

    public function select($columns) {
        $this->sql = str_replace('*', $columns, $this->sql);
        return $this;
    }

    private function generateQuery() {
        if ($this->join) {
            $this->sql .= implode(' ', $this->join);
            $this->join = null;
        }
        $this->get_where();
        if ($this->groupBy) {
            $this->sql .= $this->groupBy;
            $this->groupBy = null;
        }
        if ($this->orderBy) {
            $this->sql .= $this->orderBy;
            $this->orderBy = null;
        }
        if ($this->limit) {
            $this->sql .= $this->limit;
            $this->limit = null;
        }
        $query = $this->query($this->sql);
        return $query;
    }

    public function run() {
        $query = $this->generateQuery();
        return $query->fetchAll(parent::FETCH_ASSOC);
    }

    public function first() {
        $query = $this->generateQuery();
        return $query->fetch(parent::FETCH_ASSOC);
    }

    public function where($column, $value = '', $mark = '=', $logical = '&&') {
        $this->where[] = [
            $column,
            $value,
            $mark,
            $logical
        ];
        return $this;
    }

    public function or_where($column, $value, $mark = '=') {
        $this->where($column, $value, $mark, '||');
        return $this;
    }

    public function join($targetTable, $joinSql, $joinType = 'inner') {
        $this->join[] = ' ' . strtoupper($joinType) . ' JOIN ' . $targetTable . ' ON ' . sprintf($joinSql, $targetTable, $this->tableName);
        return $this;
    }

    public function orderBy($columnName, $sort = 'ASC') {
        $this->orderBy = ' ORDER BY ' . $columnName . ' ' . strtoupper($sort);
        return $this;
    }

    public function groupBy($columnName) {
        $this->groupBy = ' GROUP BY ' . $columnName;
        return $this;
    }

    public function limit($start, $limit) {
        $this->limit = ' LIMIT ' . $start . ',' . $limit;
        return $this;
    }

    private function get_where() {
        if (is_array($this->where) && count($this->where) > 0) {
            $this->sql .= ' WHERE ';
            $where = [];
            foreach ($this->where as $key => $arg) {
                if ($arg[2] == 'LIKE' || $arg[2] == 'NOT LIKE') {
                    $where[] = $arg[3] . ' ' . $arg[0] . ' ' . $arg[2] . ' "%' . $arg[1] . '%" ';
                } elseif ($arg[2] == 'BETWEEN' || $arg[2] == 'NOT BETWEEN') {
                    $where[] = $arg[3] . ' ' . ($arg[0] . ' ' . $arg[2] . ' ' . $arg[1][0] . ' AND ' . $arg[1][1]);
                } elseif ($arg[2] == 'FIND_IN_SET') {
                    $where[] = $arg[3] . ' FIND_IN_SET("' . (is_array($arg[1]) ? implode(',', $arg[1]) : $arg[1]) . '", ' . $arg[0] . ')';
                } elseif ($arg[2] == 'IN' || $arg[2] == 'NOT IN') {
                    $where[] = $arg[3] . ' ' . $arg[0] . ' ' . $arg[2] . '(' . (is_array($arg[1]) ? implode(',', $arg[1]) : $arg[1]) . ')';
                } else {
                    $where[] = $arg[3] . ' ' . $arg[0] . ' ' . $arg[2] . ' "' . $arg[1] . '"';
                }
            }
            $this->sql .= ltrim(implode(' ', $where), '&&');
            $this->where = null;
        }
    }

    public function insert($tableName) {
        $this->sql = 'INSERT INTO ' . $tableName;
        return $this;
    }

    public function set($columns) {
        $val = [];
        $col = [];
        foreach ($columns as $column => $value) {
            $val[] = $value;
            $col[] = $column . ' = ? ';
        }
        $this->sql .= ' SET ' . implode(', ', $col);
        $this->get_where();
        $query = $this->prepare($this->sql);
        $result = $query->execute($val);
        return $result;
    }


    public function update($tableName) {
        $this->sql = 'UPDATE ' . $tableName;
        return $this;
    }

    public function delete($tableName) {
        $this->sql = 'DELETE FROM ' . $tableName;
        return $this;
    }

    public function done() {
        $this->get_where();
        $query = $this->exec($this->sql);
        return $query;
    }

    public function lastId() {
        return $this->lastInsertId();
    }

    public function between($column, $values = []) {
        $this->where($column, $values, 'BETWEEN');
        return $this;
    }

    public function not_between($column, $values = []) {
        $this->where($column, $values, 'NOT BETWEEN');
        return $this;
    }

    public function find_in_set($column, $value) {
        $this->where($column, $value, 'FIND_IN_SET');
        return $this;
    }

    public function in($column, $value) {
        $this->where($column, $value, 'IN');
        return $this;
    }

    public function not_in($column, $value) {
        $this->where($column, $value, 'NOT IN');
        return $this;
    }

    public function like($column, $value) {
        $this->where($column, $value, 'LIKE');
        return $this;
    }

    public function not_like($column, $value) {
        $this->where($column, $value, 'NOT LIKE');
        return $this;
    }


}
