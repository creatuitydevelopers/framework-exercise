<?php
require 'vendor/autoload.php';
define('APP_ROOT_DIR', __DIR__);

$builder = new \DI\ContainerBuilder();
$builder->useAnnotations(true);
$builder->addDefinitions('app/parameters.php');
$builder->addDefinitions('app/di-factories.php');
$container = $builder->build();

$frontController = $container->get('Core\\FrontController');
$frontController->run();