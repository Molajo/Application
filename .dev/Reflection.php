<?php
$class   = new ReflectionClass('Molajo\Resource\Adapter\Css');
$methods = $class->getMethods();
var_dump($methods);
foreach ($methods as $method) {
    echo '     * @covers  ' . $method->class . '::' . $method->name . PHP_EOL;
}
