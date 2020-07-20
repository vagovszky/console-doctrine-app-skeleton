<?php
namespace AdlerBridgeTest\Mocks;

use PHPUnit\Framework\TestCase;

/**
 * Mock Builder for Doctrine objects
 */
class DoctrineMockBuilder extends TestCase
{
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManagerMock()
    {
        $mock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(
                array(
                    'getConnection',
                    'getClassMetadata',
                    'createQueryBuilder',
                    'close',
                    'persist',
                    'flush'
                )
            )
            ->getMock();
        
        $mock->expects($this->any())
            ->method('getConnection')
            ->will($this->returnValue($this->getConnectionMock()));
        $mock->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue($this->getClassMetadataMock()));
        $mock->expects($this->any())
            ->method('createQueryBuilder')
            ->will($this->returnValue($this->getQueryBuilderMock()));
 
        return $mock;
    }
    /**
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    public function getClassMetadataMock()
    {
        $mock = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadataInfo')
            ->disableOriginalConstructor()
            ->setMethods(array('getTableName'))
            ->getMock();
        $mock->expects($this->any())
            ->method('getTableName')
            ->will($this->returnValue('{tableName}'));
        return $mock;
    }
    /**
     * @return \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    public function getDatabasePlatformMock()
    {
        $mock = $this->getAbstractMock(
            'Doctrine\DBAL\Platforms\AbstractPlatform',
            array(
                'getName',
                'getTruncateTableSQL',
            )
        );
        $mock->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('postgresql'));
        $mock->expects($this->any())
            ->method('getTruncateTableSQL')
            ->with($this->anything())
            ->will($this->returnValue('#TRUNCATE {table}'));
        return $mock;
    }
    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnectionMock()
    {
        $mock = $this->getMockBuilder('Doctrine\DBAL\Connection')
            ->disableOriginalConstructor()
            ->setMethods(
                array(
                    'beginTransaction',
                    'commit',
                    'rollback',
                    'prepare',
                    'query',
                    'executeQuery',
                    'executeUpdate',
                    'getDatabasePlatform',
                )
            )
            ->getMock();
        $mock->expects($this->any())
            ->method('prepare')
            ->will($this->returnValue($this->getStatementMock()));
        $mock->expects($this->any())
            ->method('query')
            ->will($this->returnValue($this->getStatementMock()));
        $mock->expects($this->any())
            ->method('getDatabasePlatform')
            ->will($this->returnValue($this->getDatabasePlatformMock()));
        return $mock;
    }
    /**
     * @return \Doctrine\DBAL\Driver\Statement
     */
    public function getStatementMock()
    {
        $mock = $this->getAbstractMock(
            'Doctrine\DBAL\Driver\Statement',
            array(
                'bindValue',
                'execute',
                'rowCount',
                'fetchColumn',
            )
        );
        $mock->expects($this->any())
            ->method('fetchColumn')
            ->will($this->returnValue(1));
        return $mock;
    }
    
    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilderMock(){
        $mock = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->setMethods(
                array(
                   'getQuery'
                )
            )
            ->getMock();
        
        $mock->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($this->getQueryMock()));
        return $mock;
    }
    
    /**
     * @var Doctrine\ORM\AbstractQuery
     */
    public function getQueryMock(){
        $mock = $this->getAbstractMock(
            'Doctrine\ORM\AbstractQuery',
            array(
                'getScalarResult'
            )
        );
        
        $mock->expects($this->any())
            ->method('getScalarResult')
            ->willReturn([]);
        
        return $mock;
    }
    
   
    /**
     * @param string $class   The class name
     * @param array  $methods The available methods
     *
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getAbstractMock($class, array $methods)
    {
        return $this->getMockForAbstractClass(
            $class,
            array(),
            '',
            false, // was true
            false, // was true
            true,
            $methods,
            false
        );
    }
}