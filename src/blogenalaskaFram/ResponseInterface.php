<?php

namespace blog;

/**
 *Description of ResponseInterface
 * @author constancelaloux
 */
interface ResponseInterface
{
    /**
     * Redirect the user.
     * @param string $location
     */
    public function redirectResponse(string $location): void;

    /**
     * Redict to error 404.
     * @param string $location
     */
    public function redirect404(string $location): void;
}
