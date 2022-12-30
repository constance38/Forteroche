<?php

namespace blog\validator;

use blog\validator\Validator;
use RuntimeException;

/**
 * Description of MinLengthValidator
 *
 * @author constancelaloux
 */
class MinLengthValidator extends Validator
{
    protected $minLength;

    /**
     * 
     * @param type $errorMessage
     * @param type $minLength
     */
    public function __construct(string $errorMessage, int $minLength)
    {
        parent::__construct($errorMessage);

        $this->setMinLength($minLength);
    }

    /**
     * 
     * @param type $value
     * @return type
     */
    public function isValid($value): string
    {
        return strlen($value) <= $this->minLength;
    }

    /**
     * 
     * @param type $minLength
     * @throws \RuntimeException
     */
    public function setMinLength(int $minLength): void
    {
        $minLength = (int) $minLength;

        if ($minLength > 0)
        {
            $this->minLength = $minLength;
        }
        else
        {
            throw new RuntimeException('La longueur minimale doit être un nombre supérieur à 0');
        }
    }
}
