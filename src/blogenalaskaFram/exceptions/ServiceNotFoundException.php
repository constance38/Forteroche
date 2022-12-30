<?php

namespace blog\exceptions;

use Exception;

/**
 * Description of ServiceNotFoundException
 *
 * @author constancelaloux
 */
class ServiceNotFoundException extends Exception
{
    public function __construct(string $path)
    {

    }
}
