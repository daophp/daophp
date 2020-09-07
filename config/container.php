<?php

$builder = new \DI\ContainerBuilder();

$builder->addDefinitions(config('dependence', []));
$builder->useAutowiring(true);
$builder->useAnnotations(true);

return $builder->build();
