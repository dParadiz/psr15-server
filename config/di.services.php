<?php
$builder = new DI\ContainerBuilder();

$builder->useAnnotations(false);
$builder->useAutowiring(true);
//$builder->enableCompilation(__DIR__ . '/../var/container');

//$apiBase = include __DIR__ . '/di/api_base.php';
//$api = include __DIR__ . '/di/api.php';

//$builder->addDefinitions($apiBase);
//$builder->addDefinitions($api);

$di = $builder->build();

return $di;
