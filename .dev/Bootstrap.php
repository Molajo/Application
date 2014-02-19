<?php
/**
 * Bootstrap for Testing
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
include_once __DIR__ . '/CreateClassMap.php';

if (! defined('PHP_VERSION_ID')) {
    $version = explode('.', phpversion());
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

$base     = substr(__DIR__, 0, strlen(__DIR__) - 5);
$classmap = array();

$classmap = createClassMap($base . '/vendor/commonapi/controller', 'CommonApi\\Controller\\');

$results  = createClassMap($base . '/vendor/commonapi/model', 'CommonApi\\Model\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/vendor/commonapi/event', 'CommonApi\\Event\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/vendor/commonapi/resource', 'CommonApi\\Resource\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/vendor/commonapi/exception', 'CommonApi\\Exception\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller/Translations', 'Molajo\\Controller\\Translations\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller', 'Molajo\\Controller\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Model', 'Molajo\\Model\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Plugin', 'Molajo\\Plugins\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Resource/Api', 'Molajo\\Resource\\Api\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Resource/Configuration', 'Molajo\\Resource\\Configuration\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Resource/Factory', 'Molajo\\Resource\\Factory\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Resource/Handler', 'Molajo\\Resource\\Handler\\');
$classmap = array_merge($classmap, $results);

ksort($classmap);

spl_autoload_register(
    function ($class) use ($classmap) {
        if (array_key_exists($class, $classmap)) {
            require_once $classmap[$class];
        }
    }
);
