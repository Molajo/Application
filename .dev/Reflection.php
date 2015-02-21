<?php
$class   = new ReflectionClass('Molajo\Controller\Site');
$methods = $class->getMethods();
var_dump($methods);
foreach ($methods as $method) {
    echo '     * @covers  ' . $method->class . '::' . $method->name . PHP_EOL;
}
