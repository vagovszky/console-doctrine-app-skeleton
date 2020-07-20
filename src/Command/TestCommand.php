<?php
/**
 * Handle import-products console command 
 * @author Martin Vágovszký
 */
namespace Application\Command;
use Laminas\Config\Config;
use Doctrine\ORM\EntityManager;
use Application\Factory\LoggerFactory;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class TestCommand extends BaseCommand {

    protected function configure()
    {
        $this->setName('test')
             ->setDescription('Test command.')
             //->addOption('option', null, InputOption::VALUE_NONE, 'Use option.')
             ->setHelp('Test command help message.');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configuration = $this->getServiceManager()->get(Config::class);
        $logger = $this->getServiceManager()->get(LoggerFactory::class);
        $entityManager = $this->getServiceManager()->get(EntityManager::class);
        
        // $option = $input->getOption('option');
        
        $output->writeln('<fg=red>Testing...</>');
        return Command::SUCCESS;
    }
}
