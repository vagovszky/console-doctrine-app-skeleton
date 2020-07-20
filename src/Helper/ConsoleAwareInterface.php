<?php

/**
 * Console interface
 * @author Martin Vágovszký
 */

namespace Application\Helper;

use Symfony\Component\Console\Output\OutputInterface;

interface ConsoleAwareInterface {
    
    /**
     * Set Console
     * @param OutputInterface $console
     */
    public function setConsole(OutputInterface $console);
    
    /**
     * Get console
     * @return OutputInterface
     */
    public function getConsole() : OutputInterface;
    
}
