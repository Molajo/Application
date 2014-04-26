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
$results  = createClassMap($base . '/vendor/commonapi/database', 'CommonApi\\Database\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/event', 'CommonApi\\Event\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/exception', 'CommonApi\\Exception\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/ioc', 'CommonApi\\IoC\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/model', 'CommonApi\\Model\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/vendor/commonapi/resource', 'CommonApi\\Resource\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/vendor/commonapi/query', 'CommonApi\\Query\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller/Translations', 'Molajo\\Controller\\Translations\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller', 'Molajo\\Controller\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Model', 'Molajo\\Model\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Plugins', 'Molajo\\Plugins\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Resource/Adapter', 'Molajo\\Resource\\Adapter\\');
$classmap = array_merge($classmap, $results);

$classmap['Molajo\\Resource\\ExtensionMap'] = $base . '/Source/Resource/ExtensionMap.php';

$results  = createClassMap($base . '/Factories', 'Molajo\\Factories\\');
$classmap = array_merge($classmap, $results);

ksort($classmap);

spl_autoload_register(
    function ($class) use ($classmap) {
        if (array_key_exists($class, $classmap)) {
            require_once $classmap[$class];
        }
    }
);
