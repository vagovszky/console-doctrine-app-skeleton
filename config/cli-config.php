<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Config\Config;

define('APPLICATION_PATH', dirname(dirname(__FILE__)));

require_once APPLICATION_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$configuration = require_once __DIR__ . DIRECTORY_SEPARATOR . 'application.php';

$config = new Config($configuration);
$serviceManager = new ServiceManager($config->get('service_manager')->toArray());
$serviceManager->setService('Laminas\Config\Config', $config);

$entityManager = $serviceManager->get(Doctrine\ORM\EntityManager::class);

return ConsoleRunner::createHelperSet($entityManager);

