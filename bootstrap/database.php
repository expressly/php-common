<?php

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Silex\Provider\DoctrineServiceProvider;

// DBAL
//$app->register(new DoctrineServiceProvider(), array(
//    'db.options' => $app['config']['database']
//));

$app->register(new \Expressly\ServiceProvider\DatabaseServiceProvider());