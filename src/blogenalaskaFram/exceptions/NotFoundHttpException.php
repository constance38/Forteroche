<?php

namespace blog\exceptions;

use Exception;

/**
 * Description of NotFoundHttpException
 *
 * @author constancelaloux
 */
class NotFoundHttpException extends Exception
{
     public function __construct(string $path)
     {
         
     }
}
