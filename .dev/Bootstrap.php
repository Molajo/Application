<?php
/**
 * Bootstrap for Testing
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
$base     = substr(__DIR__, 0, strlen(__DIR__) - 5);
include_once $base . '/vendor/autoload.php';
if (function_exists('CreateClassMap')) {
} else {
    include_once __DIR__ . '/CreateClassMap.php';
}

$classmap = array();

$results  = createClassMap($base . '/Source/Controller/Translations', 'Molajo\\Controller\\Translations\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Controller', 'Molajo\\Controller\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Model', 'Molajo\\Model\\');
$classmap = array_merge($classmap, $results);

$results  = createClassMap($base . '/Source/Plugins/Alias', 'Molajo\\Plugins\\Alias\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Application', 'Molajo\\Plugins\\Application\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Csrftoken', 'Molajo\\Plugins\\Csrftoken\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Customfields', 'Molajo\\Plugins\\Customfields\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Events', 'Molajo\\Plugins\\Events\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Fields', 'Molajo\\Plugins\\Fields\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Footer', 'Molajo\\Plugins\\Footer\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Login', 'Molajo\\Plugins\\Login\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Logout', 'Molajo\\Plugins\\Logout\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Menuitems', 'Molajo\\Plugins\\Menuitems\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Pagetypeapplication', 'Molajo\\Plugins\\Pagetypeapplication\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Pagetypeconfiguration', 'Molajo\\Plugins\\Pagetypeconfiguration\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Pagetypedashboard', 'Molajo\\Plugins\\Pagetypedashboard\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Pagetypeedit', 'Molajo\\Plugins\\Pagetypeedit\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Pagetypegrid', 'Molajo\\Plugins\\Pagetypegrid\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Pagetypeitem', 'Molajo\\Plugins\\Pagetypeitem\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Pagetypelist', 'Molajo\\Plugins\\Pagetypelist\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Pagetypenew', 'Molajo\\Plugins\\Pagetypenew\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Pagination', 'Molajo\\Plugins\\Pagination\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Queryauthorisation', 'Molajo\\Plugins\\Queryauthorisation\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Sites', 'Molajo\\Plugins\\Sites\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Status', 'Molajo\\Plugins\\Status\\');
$classmap = array_merge($classmap, $results);
$results  = createClassMap($base . '/Source/Plugins/Translate', 'Molajo\\Plugins\\Translate\\');
$classmap = array_merge($classmap, $results);
ksort($classmap);

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
