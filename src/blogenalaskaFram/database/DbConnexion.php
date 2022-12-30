<?php

namespace blog\database;

use PDO;

use blog\DotEnv;

use PDOException;

/**
 * Description of DbConnexion
 *
 * @author constancelaloux
 */

class DbConnexion 
{
    protected $db;
    
    protected $dotEnv;

    protected function connect(): PDO
    {
        try 
        {
            $this->dotEnv = new DotEnv();
            $this->dotEnv->load(__DIR__.'/../../../.env');
            $db = new \PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'].';charset=utf8',$_ENV['DB_USER'],$_ENV['DB_PASS']);
            /**
             * An alert is issued each time a request has failed.
             */
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } 
        catch (PDOException $e) 
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    } 
}
