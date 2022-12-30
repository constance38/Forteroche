<?php

namespace blog\database;

use blog\database\DbConnexion;
use blog\database\Model;
use blog\exceptions\ORMException;

/**
 * Description of EntityManager  
 * @author constancelaloux
 */
class EntityManager extends DbConnexion
{
    /**
     * @var \PDO
     */
    protected $pdo;
    /**
     * @var string
     */
    private $model;
    /**
     * @var array
     */
    private $metadata;
    
    public function __construct(Model $model)
    {
        $this->pdo = $this->connect();

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
        $this->model = $model;
        
    }
    
    /**
     * sql queries
     */
    
    /**
     * Persist datas before to send them in database
     * It goes to update or insert if there is a primary key or not
     * @param Model $model
     */
    public function persist(Model $model): void
    {
        if($model->getPrimaryKey()) 
        {
            $this->update($model);
        }
        else
        {
            $this->insert($model);
        }
    }
    
    /**
     * Update datas in database
     * @param Model $model
     */
    private function update(Model &$model): void
    {
        $set = [];
        $parameters = [];

        foreach(array_keys($this->metadata["columns"]) as $column)
        {
            $sqlValue = $model->getSQLValueByColumn($column);
            
            $model->orignalData[$column] = $sqlValue;

            if(!empty($sqlValue))
            {
                $parameters[$column] = $sqlValue;
            }

            if(!empty($parameters[$column]))
            {
                $set[] = sprintf("%s = :%s", $column, $column);
            }       
        }
        if(count($set)) 
        {
            $sqlQuery = sprintf("UPDATE %s SET %s WHERE %s = :id", $this->metadata["table"], implode(", ", $set), $this->metadata["primaryKey"]);
            $statement = $this->pdo->prepare($sqlQuery);
            $statement->execute($parameters);
        }
    }
    
    /**
     * Insert datas in database
     * @param Model $model
     */
    private function insert(Model &$model): void
    {
        $set = [];
        $parameters = [];

        foreach(array_keys($this->metadata["columns"]) as $column)
        {
            $sqlValue = $model->getSQLValueByColumn($column);
            $model->orignalData[$column] = $sqlValue;
            
            if(!empty($sqlValue))
            {
                $parameters[$column] = $sqlValue;
            }

            if(!empty($parameters[$column]))
            {
                $set[] = sprintf("%s = :%s", $column, $column);
            }
        }
        
        $sqlQuery = sprintf("INSERT INTO %s SET %s", $this->metadata["table"], implode(",", $set));

        $statement = $this->pdo->prepare($sqlQuery);

        $statement->execute($parameters);

        $model->setPrimaryKey($this->pdo->lastInsertId());
    }
    
    /**
     * Remove datas in database
     * @param Model $model
     */
    public function remove(Model $model): void
    {
        $sqlQuery = sprintf("DELETE FROM %s WHERE %s = :id", $this->metadata["table"], $this->metadata["primaryKey"]);
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute(["id" => $model->getPrimaryKey()]);
    }
    
    /**
     * Check if there is lines with attributes we need exists in database
     * @param type $filters
     * @return type
     */
    public function exist($filters = []): int
    {
        $sqlQuery = sprintf("SELECT COUNT(*) FROM %s %s ", $this->metadata["table"], $this->where($filters));
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute($filters);
        return $statement->fetchColumn();
    }
    
    /**
     * Check if the is a line in database which corresponds to the id we ve put in args
     * The find ($id) method simply retrieves the entity corresponding to the id $id
     * @param type $id
     * @return type
     */
    public function findById(int $id): Model
    {
        return $this->fetch([$this->metadata["primaryKey"] => $id]);
    }
    
    /**
     * The findOneBy method (array $ criteria, array $ orderBy = null) works on the same principle as thefindBy () method, except that it returns only one entity.
     * The limitetoffset arguments therefore do not exist.
     * @param type $filters
     * @return type
     */
    public function findOneBy($filters = []): Model
    {
        return $this->fetch($filters);
    }
    
    /**
     * @param type $filters
     * @return type
     */
    public function fetch($filters = []): Model
    {
        $sqlQuery = sprintf("SELECT * FROM %s %s LIMIT 0,1", $this->metadata["table"], $this->where($filters));
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute($filters);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return (new $this->model($result));
    }
    
    /**
     * Request that we will use to retrieve our posts
     * FindAll method goes to fetchAll
     * The findAll () method returns all the entities contained in the database.
     * The return format is a normal PHP array (an array), which you can browse (with unforeach for example) 
     * to use the objects it contains
     * @return type
     */
    public function findAll(): ?array
    {
        return $this->fetchAll();
    }
    
    /**
     * Find a line or many lines with a spécify arg
     * The findBy () method is a little more interesting. LikeindAll (), 
     * it allows you to return a list of entities, except that it is capable of performing a filter to 
     * return only the entities corresponding to one or more criteria. It can also sort the entities, 
     * and even retrieve only a certain number (for pagination).
     * @param type $filters
     * @param type $orderBy
     * @param type $length
     * @param type $start
     * @return type
     */
    public function findBy($filters = [], $orderBy = [], $desc = null, $length = null, $start = null): array
    {
        return $this->fetchAll($filters, $orderBy, $desc, $length, $start);
    }
    
    public function get(array $filters): array
    {
        $sqlQuery = sprintf("SELECT * FROM %s %s", $this->metadata["table"], $this->where($filters));
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute($filters);
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $data = [];
        
        foreach($results as $result) 
        {
            $data[] = (new $this->model())->hydrate($result);
        }
        return $data;
    }
    
    /**
     * You know the principle of magic methods, like __call () which emulates methods. 
     * These emulated methods do not exist in the class, they are supported by__call () which will execute 
     * code according to the name of the method called.
     * @param type $name
     * @param type $arguments
     * @return type
     */
    public function __call(string $name, string $arguments): array
    {
        if(preg_match("/^findOneBy([A-Za-z]+)$/", $name, $matches)) {
            return $this->findOneBy([$matches[1] => $arguments[0]]);
        }
        elseif(preg_match("/^findBy([A-Za-z]+)$/", $name, $matches)) {
            $arguments[1] = $arguments[1] ?? [];
            $arguments[2] = $arguments[2] ?? null;
            $arguments[3] = $arguments[3] ?? null;
            return $this->fetchAll([$matches[1] => $arguments[0]], $arguments[1], $arguments[2], $arguments[3]);
        }
    }
    
    /**
     * The fetchAll method returns all the categories of the database
     * @param type $filters
     * @param type $sorting
     * @param type $length
     * @param type $start
     * @return type
     */
    private function fetchAll($filters = [], $sorting = [], $length = null, $start = null): array
    {   
        $sqlQuery = sprintf("SELECT * FROM %s %s %s %s", $this->metadata["table"], $this->where($filters), $this->orderBy($sorting), $this->limit($length, $start));
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute($filters);
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $data = [];
        
        foreach($results as $result) 
        {
            $data[] = (new $this->model())->hydrate($result);
        }
        return $data;
    }
    
    /**
     * Use in sql request to give an args
     * @param type $filters
     * @return string
     */
    private function where($filters = []): ?string
    {
        if(!empty($filters))
        {
            $conditions = [];
            foreach($filters as $property => $value) 
            {
                $conditions[] = sprintf("%s = :%s",$this->getColumnByProperty($property), $property);
            }
            return sprintf("WHERE %s", implode(" AND ", $conditions));
        }
        return "";
    }
    
    /**
     * Specify recovery order
     * @param type $sorting
     * @return string
     */
    private function orderBy($sorting = []): ?string
    {
        if(!empty($sorting)) 
        {
            $sorts = [];
            foreach($sorting as $property => $value) 
            {
                $sorts[] = sprintf("%s %s",$this->getColumnByProperty($property), $value);
            }
            return sprintf("ORDER BY %s DESC", implode(",", $sorts));
        }
        return "";
    }
    
    /**
     * 
     * @param type $property
     * @return type
     */
    public function getColumnByProperty(string $property): ?string
    {
        $property = lcfirst($property);
        $columns = array_keys(array_filter($this->metadata["columns"], function($column) use ($property) 
        {
            return $column["property"] == $property;
        }));
        $column = array_shift($columns);
        return $column;
    }
    
    /**
     * Can specify the limit
     * @param type $length
     * @param type $start
     * @return string
     */
    public function limit(?int $length, ?int $start): ?string
    {
        if($length !== null) 
        {
            if($start !== null) 
            {
                return sprintf("LIMIT %s,%s", $start, $length);
            }
            return sprintf("LIMIT %s", $length);
        }
        return "";
    }  
}
