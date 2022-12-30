<?php

namespace blog\form;

use blog\database\Model;
use blog\form\Field;

/**
 * Description of Form
 *
 * @author constancelaloux
 */
class Form
{
    protected $entity;
    protected $fields = [];

    public function __construct(Model $entity)
    {
        $this->setEntity($entity);
    }

    /**
    * We hydrate the Field object with the given values ​​to create a form.
    * Then we assign the corresponding value to the field and we generate an array with the datas
    */
    public function add(Field $field): self
    {
        /**
         * We get the name of the field.
         */
        $attr = $field->name();
        /**
         * We assign the corresponding value to the field.
         */
        $field->setValue($this->entity->$attr());
        /**
         *  We add the field passed as an argument to the list of fields.
         */
        $this->fields[] = $field; 
        return $this;
    }
    
    /**
    * Function which will generate the form.
    */
    public function createView(): string
    {
        $view = '';
        /**
         * We generate the form fields one by one.
         */
        foreach ($this->fields as $field)
        {
            $view .= $field->buildWidget().'<br />';
        }
        return $view;
    }

    /**
    * We check that all the fields are valid.
    */
    public function isValid(): bool
    {
        $valid = true;

        foreach ($this->fields as $field)
        {

            if (!$field->isValid())
            {
                $valid = false;
            }
        }
        return $valid;
    }

    public function entity(): object
    {
        return $this->entity;
    }

    public function setEntity(Model $entity): void
    {
        $this->entity = $entity;
    }
    
    public function emptyFields(): void
    {   
        
    }
}
