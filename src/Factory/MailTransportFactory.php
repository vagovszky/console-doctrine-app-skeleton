<?php
/**
 * Prepare instance of Smtp Transport
 * @author Martin Vágovszký
 */

namespace Application\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Config\Config;

use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;

class MailTransportFactory implements FactoryInterface {
    
    /**
     * Return instance of Zend\Mail\Transport\Smtp
     * @param ContainerInterface $container
     * @param String $requestedName
     * @param array $options
     * @return Smtp
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuration = $container->get(Config::class);
        $options = new SmtpOptions($configuration->mail->transport->options->toArray());
     
        return new Smtp($options);
        
    }
}