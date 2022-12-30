<?php

namespace blog\exceptions;

use Exception;

/**
 * Description of ParameterNotFoundException
 *
 * @author constancelaloux
 */
class ParameterNotFoundException extends Exception
{
    public function __construct(string $path)
    {

    }
}
