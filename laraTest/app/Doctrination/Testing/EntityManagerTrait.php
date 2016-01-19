<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 19.01.16
 * Time: 13:55
 */

namespace App\Doctrination\Testing;

use Doctrine\DBAL\Connection;
use LaravelDoctrine\ORM\Facades\EntityManager;

trait EntityManagerTrait
{

    protected function _mockEntityManagerFacade($repositoryClassName, $entityClassName)
    {
        // Now, mock the repository so it returns the mock of the employee
        $testRepository = $this
            ->_getMockBuilder($repositoryClassName)
            ->disableOriginalConstructor()
            ->getMock();

        // Last, mock the EntityManager to return the mock of the repository
        EntityManager::shouldReceive('getRepository')
            ->with($entityClassName)
            ->andReturn($testRepository);

        EntityManager::shouldReceive('getConnection')
            ->andReturn($this->_getMockConnection());
    }

    /**
     * Returns a builder object to create mock objects using a fluent interface.
     *
     * @param string $className
     *
     * @return \PHPUnit_Framework_MockObject_MockBuilder
     *
     * @since  Method available since Release 3.5.0
     */
    protected function _getMockBuilder($className)
    {
        if (method_exists($this, 'getMockBuilder')) {
            /** @var \TestCase $this */
            return $this->getMockBuilder($className);
        }
        return new \PHPUnit_Framework_MockObject_MockBuilder(new \TestCase(), $className);
    }

    /**
     * @return Connection
     */
    protected function _getMockConnection()
    {
        return $this->_getMockBuilder(Connection::class)
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
    }
}