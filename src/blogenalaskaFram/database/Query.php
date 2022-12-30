<?php

namespace blog\database;

use blog\database\DbConnexion;
use blog\database\Model;
use blog\exceptions\ORMException;

/**
 * Description of Query
 * @author constancelaloux
 */
class Query extends DbConnexion
{

    protected $pdo;

    private $select;

    private $from;

    private $where = [];

    private $order;

    private $limit;

    private $joins;

    private $params = [];
    
    private $model = [];
    
    /**
     * @param Model $model
     * @throws ORMException
     */
    
    public function __construct(Model $model)
    {
        /**
         * I connect to the database
         */
        $this->pdo = $this->connect();
        
        /**
         * Then I get the name of the object class
         */
            $reflectionClass = new \ReflectionClass($model);
            if($reflectionClass->getParentClass()->getName() == Model::class) 
            {
                $this->model = $model;

                /**
                 * I recover if each component of my class test is an int or a string, etc.
                 */
                $this->metadata = $this->model::metadata();
            }
            else
            {
                throw new ORMException("Cette classe n'est pas une entité.");
            }
    }

    /**
     * 
     * @param string $table
     * @param string $alias
     * @return \self
     */
    public function from(string $table, string $alias = null): self
    {
        $this->from = $alias === null ? $table : "$table $alias";
        return $this;
    }
    
    /**
     * @param type $field
     * @return \self
     */
    public function select(string ...$field): self
    {
        $fields = implode(', ', $field);
        $this->select = $fields;
        return $this;
    }
    
    /**
     * Allows you to specify the limit
     * @param int $length
     * @param int $offset
     * @return Query
     */
    public function limit(int $length, int $offset = 0): self
    {
        $this->limit = "$offset, $length";
        return $this;
    }
    
    /**
     * @param string $key
     * @param string $direction
     * @return \self
     */
    public function orderBy(string $key, string $direction): self
    {
        $direction = strtoupper($direction);
        if(!in_array($direction, ['ASC', 'DESC']))
        {
            $this->order[] = $key;
        }
        else 
        {
            $this->order[] = "$key $direction";
        }
        return $this;
    }
    
    /**
     * Add a link
     * @param string $table
     * @param string $condition
     * @param string $type
     * @return Query
     */
    public function join(string $table, string $condition, string $type = "left"): self
    {
        $this->joins[$type][] = [$table, $condition];
        return $this;
    }
    
    /**
     * Defines the recovery condition
     * @param string $where
     * @return \self
     */
    public function where(string ...$where): self
    {
        $this->where = $where;
        return $this;
    }
    
    /**
     * 
     * @return int
     */
    public function count(): int
    {
        $this->select("COUNT(id)");
        return $this->execute()->fetchColumn();
    }
    
    /**
     * 
     * @param string $key
     * @param type $value
     * @return \self
     */
    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }
    
     /**
     * 
     * @param string $key
     * @param type $value
     * @return \self
     */
    public function setParams(array ...$params): self
    {
        $this->params = $params;
        return $this;
    }
    
    /**
     * 
     * @param string $entity
     * @return \self
     */
    public function into(string $entity): self
    {
        $this->entity = $entity;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function toSQL(): string
    {
        $sql = NULL;
        
        if ($this->select)
        {
            $sql .= " SELECT " . $this->select;
        }
        else 
        {
            $sql .=  " SELECT " . '*';
            
        }
        if($this->from)
        {
            $sql .= " FROM " . $this->from;
        }
        if(!empty($this->joins))
        {
            foreach ($this->joins as $type => $joins) 
            {
                foreach ($joins as $condition) 
                {
                    $sql .= ' '.strtoupper($type).' '. "JOIN $condition[0] ON $condition[1]";
                }
            }
        }
        if($this->where)
        {
            foreach ($this->where as $value) 
            {
                $sql .= " WHERE " . $value;
            }
        }
        if(!empty($this->order))
        {
            $sql .= " ORDER BY " . implode(', ', $this->order);
        }
        if($this->limit !== null)
        {
            $sql .= " LIMIT " . $this->limit;
        }  
        return $sql;
    }
   
    public function fetchAll(): ?array
    {
        $query = $this->toSQL();
        if($this->params)
        {
            $query = $this->pdo->prepare($query);
            if(is_array($this->params))
            {
                foreach ($this->params as $values)
                {
                    $query->execute($values);
                }
            }
            else 
            {
                $query->execute($this->params);
            }
            $results = $query->fetchAll(\PDO::FETCH_OBJ);
  
            $data = [];

            foreach($results as $result) 
            {
                $data[] = (new $this->model)->hydrate($result);
            }
        }
            return $data;
    }
    
    /**
     * Build the from a as b ....
     * @return string
     */
    private function buildFrom(): string
    {
        $from = [];
        foreach ($this->from as $key => $value)
        {
            if(is_string($key))
            {
                $from[] = "$value as $key";
            }
            else
            {
                $from[] = $value;
            }
        }
        return join(', ', $from);
    }
    
    /**
     * Closes the \PDO connection to the database
     */
    public function close(): void
    {
        $this->pdo = null;
    }
}
