<?php

namespace blog;

use blog\RequestInterface;

/**
* Description of HTTPRequest
* Client request
* @author constancelaloux
*/

class HTTPRequest implements RequestInterface
{
    /**
     * Obtain a cookie.
     * @param type $key
     * @return type
     */
    public function cookieData(string $key): string
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    /**
     * Check if the cookie variable exists
     * @param type $key
     * @return type
     */
    public function cookieExists(string $key): string
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * Get a GET variable.
     * @param type $key
     * @return type
     */
    public function getData($key): ?string
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * Check if there is a get variable that exists.
     * @param type $key
     * @return type
     */
    public function getExists(string $key): string
    {
        return isset($_GET[$key]);
    }

    /**
     * Obtain the method used to send the request (GET or POST method).
     * @return type
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get a POST variable.
     * @param type $key
     * @return type
     */
    public function postData(string $key): ?string
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }
    /*public function postData()
    {
        return isset($_POST) ? $_POST : null;
    }*/

    /**
     * Check if there is a post variable that exists.
     * @param type $key
     * @return type
     */
    public function postExists(string $key): string
    {
        return isset($_POST[$key]);
    }

    /**
     * Get the URL entered (useful for the router to know the desired page).
     * @return string
     */
    public function requestURI(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Returns the session variable.
     * @return type
     */
    public function getSession(): string
    {
        return $_SESSION[$key];
    }
    
    /**
     * Check if there is a session that exists.
     * @param type $key
     * @return type
     */
    public function sessionExists(string $key): string
    {
        return isset($_SESSION[$key]);
    }
}
