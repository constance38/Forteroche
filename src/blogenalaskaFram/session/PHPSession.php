<?php

namespace blog\session;

use blog\session\SessionInterface;

/**
 * Description of PHPSession
 *
 * @author constancelaloux
 */

class PHPSession implements SessionInterface
{ 
    /**
     * Check/ensure that the session has well started.
     * It will charge the session when we need if
     */
    private function ensureSarted()
    {   
        if(session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }
    
    /**
     * Get an information in session
     * @param string $key
     * @param type $default
     * @return type
     */
    public function get(string $key, $default = null): array
    {
        $this->ensureSarted();
        if(array_key_exists($key, $_SESSION))
        {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Add an information in session
     * @param string $key
     * @param type $value
     */
    public function set(string $key, array $value): void
    {
        $this->ensureSarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Delete a key in session
     * @param string $key
     */
    public function delete(string $key): void
    {
        $this->ensureSarted();
        unset($_SESSION[$key]);
    }
}
