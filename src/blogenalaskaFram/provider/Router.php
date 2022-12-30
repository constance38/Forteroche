<?php

namespace blog\provider;
use blog\provider\Route;
use blog\exceptions\RouterException;
use blog\HTTPResponse;
use blog\HTTPRequest;

/**
 * Description of Router
 *
 * Register and match routes
 * To start our Router we will create a first class Router.
 * This class will add URLs to capture, but also the code to execute
 */
class Router 
{
    private $response;
    /**
     * Contains the URL we want to go to
     * @var type 
     */
    private $request;
    
    /**
     * Will contain the list of routes
     * @var type 
     */
    private $routes = [];
    private $namedRoutes = [];
    
    private $route;
    
    const NO_ROUTE = 1;

    public function __construct(string $request, HTTPResponse $response)
    {
        $this->request = $request;
        $this->response = $response;
        //$this->route = new Route($path, $callable);
    }

    /**
     * We test a get url
     * We will start with the get () method which will take 2 parameters
     * - The URL to capture
     * - The method to call when this URL is captured.
     * We are going to use the anonymous functions that have appeared recently.
     * In case I have get functions in my routes
     * @param type $path
     * @param type $callable
     * @param type $name
     * @return type
     */
    public function get(string $path, string $callable, $name = null): object
    {
        /**
         * I add to the add function of my class router, the path of the url, the name of the controller 
         * and its function, as well as the global variable in get
         */
        return $this->add($path, $callable, $name, 'GET');
    }
    
    /**
     * We test a post url
     * In case I have post functions in my routes
     * @param type $path
     * @param type $callable
     * @param type $name
     * @return type
     */
    public function post(string $path, string $callable, $name = null): object
    {
        /**
         * I add to the add function of my class router, the path of the url, the name of the controller 
         * and its function, as well as the global variable in post
         */
        return $this->add($path, $callable, $name, 'POST');
    }
    
    /**
     * We test one of the functions in get and in post in my routes
     * @param type $path
     * @param type $callable
     * @param type $name
     * @return type
     */
    public function match(string $path, string $callable, $name = null): string
    {
        return $this->add($path, $callable, $name, 'GET|POST');
    }
    
    /**
     * We have a table which saves the different routes
     * I will add a new route
     * @param type $path
     * @param type $callable
     * @param type $name
     * @param type $method
     * @return Route
     */
    private function add(string $path, string $callable, ?string $name, string $method): object 
    {
        /**
         * I create a route object or I configure the path of the url and the controller data
         */
        $route = new Route($path, $callable);
        //$route = $this->route;
        
        /**
         * I store the list of my routes in my route object
         */
        $this->routes[$method][] = $route;
        
        /**
         * If the name of my controller is a character string and the variable name is null
         */
        if(is_string($callable) && $name === null)
        {
            /**
             * Then the name of the controller is stored in variable name
             */
            $name = $callable;
        }
        /**
         * If i have a variable name
         */
        if($name)
        {
            /**
             * I store in $routes the routes which have a callable.
             */
            $this->namedRoutes[$name] = $route;
        }
        /**
         * We return the routes to "chain" the methods
         */
        return $route; 
    }

    /**
     * This function will go through the different routes previously recorded and check if the route 
     * corresponds to the URL which is passed to the constructor, this thanks to the match () function of 
     * our Route. If no route corresponds to the URL or to the method then we are going to throw an 
     * Exception which can then be caught to manage a correct display of errors.
     * @param type $request
     * @return type
     * @throws RouterException
     */
    public function map(HTTPRequest $request): ?string
    {
        /**
         * Does one of the url match?
         * show if its in get orpost
         * I am calling the HTTP request method function which will search if the server method is in get or post
         */
        $requestMethod = $request->method();
        
        /**
         * If there is no get or post method then I throw an exception
         */
        if(!isset($this->routes[$requestMethod]))
        {
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        else
        {
        /**
         * In case where I have a get or post method then I travel the routes of the table
         */
            foreach($this->routes[$requestMethod] as $allroutes)
            {
                /**
                 * If in the route table there is a route that corresponds to the url that was typed
                 */
                if($allroutes->match($this->request))
                {
                    /**
                     * So I return a route and call the call function
                     */
                    return $allroutes->call();
                }
            }
        }
        throw new RouterException('No matching routes');
        //throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
    }

    /**
     * It takes in parameters the name of the route and the params in an array
     * @param type $name
     * @param type $params
     * @return type
     * @throws RouterException
     */
    public function url(string $name, $params=[]): string
    {
        /**
         * Does the url match and then i run it
         */
        if(!isset($this->namedRoutes[$name]))
        {
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}
