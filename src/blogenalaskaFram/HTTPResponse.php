<?php

namespace blog;

use blog\ResponseInterface;

/**
* Description of HTTPResponse
* Ce que l'on va renvoyer au client.
* @author constancelaloux
*/

class HTTPResponse implements ResponseInterface
{  
    /**
    * @return string
     * Redirect user
    */
    public function redirectResponse(string $location): void
    {
        header('Location: '.$location);
        exit;
    }

    /**
    * @return string
     * Redirect to error 404
    */
    public function redirect404(string $location): void
    {
        header('Location: '.$location);
        exit("");
    }
}
