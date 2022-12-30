<?php

namespace blog;

/**
 *Description of RequestInterface
 * @author constancelaloux
 */
interface RequestInterface 
{
    /**
     * Get the URL entered (useful for the router to know the desired page)
     */
    public function requestURI(): string;

    /**
     * Obtain a cookie.
     * @param type $key
     */
    public function cookieData(string $key): string;

    /**
     * Check if the cookie variable exists
     * @param type $key
     */
    public function cookieExists(string $key): string;

    /**
     * Get a get variable
     * @param type $key
     */
    public function getData($key): ?string;
    //public function getData();
       
    /**
     * Check if there is a get variable that exists.
     * @param type $key
     */
    public function getExists(string $key): string;

    /**
     * Obtain the method used to send the request (GET or POST method).
     */
    public function method(): string;

    /**
     * Get a POST variabl
     * @param type $key
     */
    public function postData(string $key): ?string;

    /**
     * Check if there is a post variable that exists.
     * @param type $key
     */
    public function postExists(string $key): string;
    
    /**
     * returns the session variable.
     */
    public function getSession(): string;

    /**
     * Check if there is a session that exists.
     * @param type $key
     */
    public function sessionExists(string $key): string;
}
