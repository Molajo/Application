<?php
/**
 * Bootstrap for Testing
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
$base = substr(__DIR__, 0, strlen(__DIR__) - 5);
include_once $base . '/vendor/autoload.php';

if (function_exists('CreateClassMap')) {
} else {
    include_once __DIR__ . '/CreateClassMap.php';
}

$classmap = array();

$results  = createClassMap($base . '/vendor/commonapi/cache', 'CommonApi\\Cache\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/controller', 'CommonApi\\Controller\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/event', 'CommonApi\\Event\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/exception', 'CommonApi\\Exception\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/ioc', 'CommonApi\\IoC\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/language', 'CommonApi\\Language\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/model', 'CommonApi\\Model\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/query', 'CommonApi\\Query\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/resource', 'CommonApi\\Resource\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller/Application', 'Molajo\\Controller\\Application\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller/FrontController', 'Molajo\\Controller\\FrontController\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller/NumberToText', 'Molajo\\Controller\\NumberToText\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller/Resource', 'Molajo\\Controller\\Resource\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller', 'Molajo\\Controller\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Resource/Adapter', 'Molajo\\Resource\\Adapter\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Resource', 'Molajo\\Resource\\');
$classmap = array_merge($classmap, $results);

ksort($classmap);

spl_autoload_register(
    function ($class) use ($classmap) {
        if (array_key_exists($class, $classmap)) {
            require_once $classmap[$class];
        }
    }
);

//include_once __DIR__ . '/' . 'Reflection.php';
