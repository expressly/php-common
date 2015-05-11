<?php

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Silex\Provider\DoctrineServiceProvider;

// DBAL
$app->register(new DoctrineServiceProvider(), array(
    'db.options' => $app['config']['database']
));

// Annotations
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

// Doctrine ORM
$app->register(new DoctrineOrmServiceProvider(), array(
    'orm.proxies_dir' => __DIR__ . '/../src/Proxy',
    'orm.auto_generate_proxies' => true,
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'namespace' => 'Expressly\Entity',
                'use_simple_annotation_reader' => false,
                'path' => __DIR__ . '/../src/Entity'
            )
        )
    )
));