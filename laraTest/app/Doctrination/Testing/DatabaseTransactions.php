<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 28.12.15
 * Time: 13:11
 */

namespace App\Doctrination\Testing;

use App\Doctrination\Entities\Article;
use App\Doctrination\Repositories\ArticleRepository;
use Doctrine\DBAL\Connection;
use Illuminate\Foundation\Testing\DatabaseTransactions as EloquentDatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;
use LaravelDoctrine\ORM\Facades\EntityManager;

/**
 * Class DatabaseTransactions
 *
 * @package App\Doctrination\Testing
 */
trait DatabaseTransactions
{

    use EloquentDatabaseTransactions;

    /**
     * @before
     *
     * @var $this TestCase
     */
    public function beginDatabaseTransaction()
    {
        $em = app('em');
        /** @var \Doctrine\ORM\EntityManager $em */
        $em->getConnection()->beginTransaction();

        $this->beforeApplicationDestroyed(
            function () {
                $em = app('em');
                /** @var \Doctrine\ORM\EntityManager $em */
                $em->getConnection()->rollBack();
            }
        );
    }

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