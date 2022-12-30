<?php

namespace blog\form;

use \blog\validator;

/**
 * Hydrate the field object with the datas that was sent to create a form
 */
/**
 * Description of Field 
 *
 * @author constancelaloux
 */
abstract class Field 
{
    use \blog\Hydrator;

    protected $errorMessage;
    protected $validators = [];
    protected $label;
    protected $name;
    protected $value;
    protected $type;

    public function __construct(array $options = [])
    {
        if (!empty($options))
        {
            $this->hydrate($options);
        }
    }

    abstract public function buildWidget(): string;

    public function isValid(): bool
    {
        foreach ($this->validators as $validator)
        {
            if (!$validator->isValid($this->value))
            {
                $this->errorMessage = $validator->errorMessage();
                return false;
            }
        }

        return true;
    }
    
    /**
     * Getters
     */
    public function label(): string
    {
        return $this->label;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function type(): string
    {
        return $this->type;
    }   

    public function length(): int
    {
        return $this->length;
    }
    
    public function validators(): string
    {
        return $this->validators;
    }

    /**
     * Setters
     */
    public function setLabel(string $label): void
    {
        if (is_string($label))
        {
            $this->label = $label;
        }
    }

    public function setName(string $name): void
    {
        if (is_string($name))
        {
            $this->name = $name;
        }
    }

    public function setValue(?string $value): void
    {
        if (is_string($value))
        {
            $this->value = $value;
        }
    }

    public function setType(string $type): void
    {
        if (is_string($type))
        {
            $this->type = $type;
        }
    }
    
    public function setLength(int $length): void
    {
        $length = (int) $length;

        if ($length > 0)
        {
            $this->length = $length;
        }
    }
    
    public function setValidators(array $validators): void
    {
        foreach ($validators as $validator)
        {
            if ($validator instanceof validator\Validator && !in_array($validator, $this->validators))
            {
                $this->validators[] = $validator;
            }
        }
    }
}
