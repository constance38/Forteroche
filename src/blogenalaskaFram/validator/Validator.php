<?php
namespace blog\validator;

/**
 * Description of Validator
 *
 * @author constancelaloux
 */
abstract class Validator 
{
    protected $errorMessage;
  
    /**
     * 
     * @param type $errorMessage
     */
    public function __construct(string $errorMessage)
    {
        $this->setErrorMessage($errorMessage);
    }
  
    /**
     * 
     */
    abstract public function isValid(string $value): string;
  
    /**
     * 
     * @param type $errorMessage
     */
    public function setErrorMessage(string $errorMessage): void
    {
        if (is_string($errorMessage))
        {
          $this->errorMessage = $errorMessage;
        }
    }
  
    /**
     * 
     * @return type
     */
    public function errorMessage(): string
    {
        return $this->errorMessage;
    }  
}
