<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 19.01.16
 * Time: 13:55
 */

namespace App\Doctrination\Testing;

use App\Doctrination\Entities\Article;
use App\Doctrination\Repositories\ArticleRepository;
use Doctrine\DBAL\Connection;
use Illuminate\Foundation\Testing\TestCase;
use LaravelDoctrine\ORM\Facades\EntityManager;

trait EntityManagerTrait
{

    protected function _mockEntityManagerFacade()
    {
        // Now, mock the repository so it returns the mock of the employee
        /** @var TestCase $this */
        $testRepository = $this
            ->getMockBuilder(ArticleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Last, mock the EntityManager to return the mock of the repository
        EntityManager::shouldReceive('getRepository')
            ->with(Article::class)
            ->andReturn($testRepository);

        /** @var DatabaseTransactions $this */
        EntityManager::shouldReceive('getConnection')
            ->andReturn($this->_getMockConnection());
    }

    /**
     * @return Connection
     */
    protected function _getMockConnection()
    {
        /** @var TestCase $this */
        return $this->getMockBuilder(Connection::class)
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