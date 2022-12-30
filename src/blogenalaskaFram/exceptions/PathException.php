<?php

namespace blog\exceptions; 

use blog\exceptions\ExceptionInterface;

/**
 * Thrown when a file does not exist or is not readable.
 * Description of PathException
 *
 * @author constancelaloux
 */

final class PathException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(string $path, int $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('Unable to read the "%s" environment file.', $path), $code, $previous);
    }
}