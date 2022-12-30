<?php

namespace blog\database;

use DateTime;
use blog\exceptions\ORMException;
use stdClass;

/**
 * Class Model
 * @package App\ORM
 */
class Model
{
    /**
     * @var array
     */
    public $originalData = [];
    
    protected $erreurs = [];
    
    /**
     * 
     * @param type $donnees
     */
    public function __construct($donnees = [])
    {
        if (!empty($donnees))
        {
            $this->hydrate($donnees);
        }
    }
    
    /**
     * 
     * @param array $result
     * @param array $model
     * @return $this
     * @throws ORMException
     */
    public function hydrate($result, ?array $model = null): self
    {
        if(empty($result)) 
        {
            throw new ORMException("Aucun résultat n'a été trouvé !");
        }
        $this->originalData = $result;

        foreach($this->originalData as $column => $value) 
        {
            $this->hydrateProperty($column, $value);
        }
        return $this;
    }

    /**
     * 
     * @param type string $column
     * @param type string/null $value
     * @return void
     */
    private function hydrateProperty(string $column, ?string $value): void
    {
        if(isset($this::metadata()["table"]))
        {
                if(isset($this::metadata()["columns"][$column]))
                {
                    switch($this::metadata()["columns"][$column]["type"]) 
                    {
                        case "integer":
                            $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}((int) $value);
                            break;
                        case "string":
                            $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($value);
                            break;
                        case "datetime":
                            $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($value);
                            break;
                    }
                }
        }
    }

    /**
     * 
     * @param type $column
     * @return DateTime
     */
    public function getSQLValueByColumn(string $column): ?string
    {
        $value = $this->{sprintf("get%s",ucfirst($this::metadata()["columns"][$column]["property"]))}();
        if($value instanceof \DateTime)
        {
            return $value->format("Y-m-d H:i:s");
        }
        return $value;
    }

    /**
     * 
     * @param type $value
     */
    public function setPrimaryKey(int $value): void
    {
        $this->hydrateProperty($this::metadata()["primaryKey"], $value);
    }

    /**
     * get the id that will increment in the database
     * @return type
     */
    public function getPrimaryKey(): ?int
    {
        /**
         * I get the name of the primary key id
         */
        $primaryKeyColumn = $this::metadata()["primaryKey"];

        $property = $this::metadata()["columns"][$primaryKeyColumn]["property"];

        /**
         * I'm going to return the id getter
         */
        return $this->{sprintf("get%s",ucfirst($property))}();
    }
}
