<?php
$class   = new ReflectionClass('Molajo\Resource\Proxy');
$methods = $class->getMethods();
var_dump($methods);
foreach ($methods as $method) {
    echo '     * @covers  ' . $method->class . '::' . $method->name . PHP_EOL;
}
