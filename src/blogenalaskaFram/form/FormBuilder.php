<?php

namespace blog\form;

use blog\form\Form;
use blog\database\Model;

/**
 * Description of FormBuilder
 *
 * @author constancelaloux
 */
abstract class FormBuilder 
{
    protected $form;

    public function __construct(Model $entity)
    {
        $this->setForm(new Form($entity));
    }

    /**
     * Refer to the form function from the form created in php
     */
    abstract public function form(): void;

    public function setForm(form $form): void
    {
        $this->form = $form;
    }

    /**
     * Function that returns the form that we have created
     */
    public function buildform(): object
    {
        return $this->form;
    }
}
