<?php // tests/connection.php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require __DIR__ . '/../vendor/autoload.php';

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/../src"),
    isDevMode: true,
);

$connection = DriverManager::getConnection([
    'url' => 'sqlite:///:memory:'
], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);
