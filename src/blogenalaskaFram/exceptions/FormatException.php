<?php

namespace blog\exceptions;

use blog\exceptions\ExceptionInterface;

/**
 * Thrown when a file has a syntax error.
 * Description of FormatException
 *
 * @author constancelaloux
 */
final class FormatException extends \LogicException implements ExceptionInterface
{
    private $context;
    
    public function __construct(string $message, FormatExceptionContext $context, int $code = 0, \Exception $previous = null)
    {
        $this->context = $context;
        parent::__construct(sprintf("%s in \"%s\" at line %d.\n%s", $message, $context->getPath(), $context->getLineno(), $context->getDetails()), $code, $previous);
    }
    
    public function getContext(): FormatExceptionContext
    {
        return $this->context;
    }
}