<?php
/**
 * Prepare instance of Doctrine's Entity Manager
 * @author Martin Vágovszký
 */

namespace Application\Factory;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Config\Config;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

class DoctrineFactory implements FactoryInterface {
    

    /**
     * Return an instance of Doctrine\ORM\EntityManager
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return EntityManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        
        $configuration = $container->get(Config::class);
        
        $paths = $configuration->doctrine->get('entity_paths')->toArray();
        $params = $configuration->doctrine->get('params')->toArray();
        $tmpDir = $configuration->get('tmp_dir');
        
        $cache = new ArrayCache();
        
        $reader = new AnnotationReader();
        $driver = new AnnotationDriver($reader, $paths);

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);
        $config->setMetadataCacheImpl( $cache );
        $config->setQueryCacheImpl( $cache );
        $config->setMetadataDriverImpl( $driver );
        $config->setProxyDir( $tmpDir );
        $config->setProxyNamespace( 'Application\Proxies' );
        $config->setAutoGenerateProxyClasses( true );

        return EntityManager::create($params, $config);
        
    }
}

