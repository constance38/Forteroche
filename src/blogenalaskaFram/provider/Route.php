<?php

namespace blog\provider;

/**
 * Description of Route
 * @objet which represent a route
 */

class Route 
{
    /**
     * Corresponds to the path of the url
     */
    private $path;
    
    /**
     * Corresponds to the name of the controller and its function that we write in the route
     */
    private $callable;
    
    /**
     *
     * @var type 
     */
    private $matches = [];
    
    /**
     * Corresponds to the parameters of the url that we add. Id, etc
     */
    private $params = [];

    
    public function __construct(string $path, string $callable)
    {
        $this->path = trim($path, '/'); 
        /**
         * We remove the / unnecessary
         */
        $this->callable = $callable;
    }
    
    /**
     * In case my routes have parameters
     */
    public function with(string $param, string $regex): self
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        /**
         * We always return the object to chain the arguments
         */
        return $this; 
    }
    
    /**
     * I check if in the route table there is a route that corresponds to the url
     */
    public function match(string $request): bool
    {
        /**
         * We remove the / initials and endings of the url
         * Remove spaces (or other characters) at the beginning and end of the string
         */
        $request = trim($request, '/');

        /**
         * We replace the: id with a regular expression
         * Attention if I have a parameter it must be replaced by a regular expression
         * We want to replace it with anything that is not a slash / and we replace it in the path that is in parameter
         */
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        
        /**
         * We want to transform this into a regular expression that will check the chain
         * i = case sensitive
         * The flag i allows you to check the upper and lower case
         */
        $regex = "#^$path$#i";
        
        /**
         * If url doesnt match
         */
        if(!preg_match($regex, $request, $matches))
        {
            return false;
        }
        
        /**
         * Otherwise it will detect the url
         */
        array_shift($matches);
        $this->matches = $matches;  
        /**
         * Save the parameters in the instance for later
         */
        
        /**
         * If the url matches, I return true
         */
        return true;
    }
    
    /**
     * In case I have a parameter
     */
    private function paramMatch(array $match): string
    {
        /**
         * If I ever have a param in my params that matches the id, then
         */
        if(isset($this->params[$match[1]]))
        {
            return '(' . $this->params[$match[1]].')';
        }
        return '([^/]+)';
    }
    
    /**
     * Then, we will add a method allowing to execute the anonymous function by passing to it the parameters 
     * recovered during preg_match ().
     * I have an array with the controller and its function, and then
     * I get the correspondans controller and I create an instance to call its function
     */
    public function call(): ?string
    {
        /**
         * If the name of the controller and its function are indeed strings
         * return call_user_func_array($this->callable, $this->matches);
         */
        if(is_string($this->callable))
        {
            /**
             * I have two elements in my array. The name of the controller and the function
             */
            $params = explode('#', $this->callable);

            /**
             * I go to the controller corresponds to the name of the controller which in the table is param index 0
             */
            $controller = "blog\\controllers\\" . $params[0] . "Controller";
            
            /**
             * I create a controller instance so I can call its function
             */
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        }
        else
        {
            return call_user_func_array($this->callable, $this->matches);
        }
    }
    
    /**
     * 
     * @param type $params
     * @return type
     */
    public function getUrl(array $params): string
    {
        $path = $this->path;
        foreach($params as $k => $v)
        {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}
