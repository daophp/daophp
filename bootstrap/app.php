<?php

use DI\ContainerBuilder;

$app = new ContainerBuilder();

$app->useAutowiring(true);
$app->useAnnotations(true);

return $app->build();
