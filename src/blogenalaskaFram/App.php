<?php

namespace blog;
use blog\provider\Router;
use blog\HTTPResponse;
use blog\HTTPRequest;
/**
 * Description of App
 *
 * @author constancelaloux
 */
class App
{ 
    /**
    * Allows you to retrieve the URI that was provided to access this page and then
    * the router needs the URI which will be the request and the response object to function
    * @author constancelaloux
    */
    public function run(): void
    {
        $request = new HTTPRequest();
        $response = new HTTPResponse();
        
        $uri = $request->requestURI();

        $router = new Router($uri, $response);
        require (__DIR__ . '/routes/Routes.php');
        /**
         * Must verify that the url passed in parameter corresponds to one of the urls
         */
        $router->map($request);
    }
}
