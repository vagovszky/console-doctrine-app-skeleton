<?php

namespace Application\Command;

use Symfony\Component\Console\Command\Command;
use Laminas\ServiceManager\ServiceLocatorInterface;

class BaseCommand extends Command {

    private $serviceManager;
    
    public function __construct(ServiceLocatorInterface $serviceManager, $name = null) {
        $this->serviceManager = $serviceManager;
        parent::__construct($name);
    }
    
    /**
     * Get ServiceManager
     * @return ServiceLocatorInterface
     */
    public function getServiceManager(): ServiceLocatorInterface {
        return $this->serviceManager;
    }
}
