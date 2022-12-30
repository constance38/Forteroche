<?php

/* 
 * List of namespaces
 */

require(__DIR__ . '/Autoloader.php');

$loader = new blog\Autoloader();
$loader->register();

$loader->addNamespace('blog', __DIR__ . '/../../src/blogenalaskaFram');
$loader->addNamespace('blog\provider', __DIR__ . '../../src/blogenalaskaFram/provider');
$loader->addNamespace('blog\controllers', __DIR__ . '../../src/blogenalaskaFram/controllers');
$loader->addNamespace('blog\database', __DIR__ . '../../src/blogenalaskaFram/provider');
$loader->addNamespace('blog\HTML', __DIR__ . '../../src/blogenalaskaFram/HTML');
$loader->addNamespace('blog\session', __DIR__ . '../../src/blogenalaskaFram/session');
$loader->addNamespace('blog\exceptions', __DIR__ . '../../src/blogenalaskaFram/exceptions');
$loader->addNamespace('blog\form', __DIR__ . '../../src/blogenalaskaFram/form');
$loader->addNamespace('blog\validator', __DIR__ . '../../src/blogenalaskaFram/validator');
$loader->addNamespace('blog\entity', __DIR__ . '../../src/blogenalaskaFram/entity');
$loader->addNamespace('blog\file', __DIR__ . '../../src/blogenalaskaFram/file');
$loader->addNamespace('blog\error', __DIR__ . '../../src/blogenalaskaFram/error');
$loader->addNamespace('blog\user', __DIR__ . '../../src/blogenalaskaFram/user');
$loader->addNamespace('blog\service', __DIR__ . '../../src/blogenalaskaFram/service');