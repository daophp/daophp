<?php

// 如果你需要自动依赖注入(包括注解注入)。
// 请先运行 composer require php-di/php-di && composer require doctrine/annotations
// 并将下面的代码注释解除，并注释掉最后一行 return new Swift\Container\Container;
/*$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(config('dependence', []));
$builder->useAutowiring(true);
$builder->useAnnotations(true);
return $builder->build();*/

return new \Swift\Container\ContainerProvider();
