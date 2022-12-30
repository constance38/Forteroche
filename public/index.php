<?php

/**
 * index.php has a entry point with the rest of the app
 */

/**
 * Report errors php
 */
error_reporting(E_ALL);
ini_set('display_errors', 'on');

/**
 * Time to load the page
 */
define('DEBUG_TIME', microtime(TRUE));
sleep(2);

/**
 * Autoload
 */
require(__DIR__ . '/../src/blogenalaskaFram/Autoload.php');


/**
 * Get app to charge
 */
/**
 * instance class
 * use, can import a class from another folder"
 */

use blog\App;
$app =(new App());
/**
 * i give the request to app and then this app can return a response
 */
$app->run();