<?php
use Laminas\ServiceManager\ServiceManager;
use Laminas\Config\Config;
use Application\Factory\LoggerFactory;

use Symfony\Component\Console\Application;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleErrorEvent;

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;

use Application\Command\TestCommand;

define('APPLICATION_PATH', dirname(dirname(__FILE__)));
require_once APPLICATION_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$configuration = require_once APPLICATION_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'application.php';
define('VERSION', $configuration['version']);

// Prepare Service Manager
$config = new Config($configuration);
$serviceManager = new ServiceManager($config->get('service_manager')->toArray());
$serviceManager->setService('Laminas\Config\Config', $config);

// Prepare error handling
$dispatcher = new EventDispatcher();
$dispatcher->addListener(ConsoleEvents::ERROR, function (ConsoleErrorEvent $event) use ($serviceManager) {
    $output = $event->getOutput();
    $command = $event->getCommand();
    $error = $event->getError();
    $configuration = $serviceManager->get(Config::class);
    $logger = $serviceManager->get(LoggerFactory::class);
    $debug = $configuration->get('debug');
    
    $errorMessage  = "===============================================================\n";
    $errorMessage .= "       The application has thrown an exception!                \n";
    $errorMessage .= "===============================================================\n\n";
    $errorMessage .= "Class: ".get_class($error)."\n";
    $errorMessage .= "Message: ".$error->getMessage()."\n";
    $errorMessage .= "Code: ".$error->getCode()."\n";
    $errorMessage .= "File: ".$error->getFile()."\n";
    $errorMessage .= "Line: ".$error->getLine()."\n";
    $errorMessage .= "Trace: ".$error->getTraceAsString()."\n\n";
    $errorMessage .= "===============================================================";
    
    if(!$debug){
        $logger->crit(PHP_EOL.$errorMessage.PHP_EOL);
    }
    $output->writeln(sprintf('Oops, exception thrown while running command <info>%s</info>', $command->getName()));
});

// =======================
// Prepare application
// =======================
$application = new Application('Application', VERSION);
$application->setDispatcher($dispatcher);
$application->setHelperSet(ConsoleRunner::createHelperSet($serviceManager->get(EntityManager::class))); // Set Doctrine helpers

// Commands
$application->add(new TestCommand($serviceManager));

// Add doctrine commands
ConsoleRunner::addCommands($application); 

// Run it
$application->run();