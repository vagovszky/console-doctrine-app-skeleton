<?php

/**
 * Interface requiring Application\Config
 */

namespace Application\Helper;

use Laminas\Config\Config;

interface ConfigurationAwareInterface {
    
    /**
     * Set Config
     * @param Config $configuration
     */
    public function setConfiguration(Config $configuration);
    
    /**
     * Get configuration
     */
    public function getConfiguration();
}

