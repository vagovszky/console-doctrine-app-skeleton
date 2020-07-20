<?php
/**
 * Prepare instance of Logger
 * @author Martin Vágovszký
 */

namespace Application\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Config\Config;

use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;
use Laminas\Log\Writer\Mail;

use Application\Factory\MailTransportFactory;

class LoggerFactory implements FactoryInterface {
    
    /**
     * Return instance of Zend\Log\Logger
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return Logger
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        
        $configuration = $container->get(Config::class);
        $transport = $container->get(MailTransportFactory::class);
        
        $streamWriter = new Stream($configuration->log->stream);
        
        $mailWriter = new Mail([
            'subject_prepend_text' => 'Application ' . VERSION . ' |',
            'transport' => $transport,
            'mail' => [
                'to' => $configuration->mail->recipients->toArray(),
                'from' => $configuration->mail->transport->options->connection_config->username
            ],
            'filters' => [
                'priority' => [
                    'name' => 'priority',
                    'options' => [
                        'operator' => '<=',
                        'priority' => \Laminas\Log\Logger::NOTICE,
                    ],
                ],
            ],
            'formatter' => [
                'name' => \Laminas\Log\Formatter\Simple::class
            ]
        ]);

        $logger = new Logger();
        $logger->addWriter($streamWriter);
        $logger->addWriter($mailWriter);
        
        return $logger;
       
    }
}