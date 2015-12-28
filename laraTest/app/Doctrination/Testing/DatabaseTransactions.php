<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 28.12.15
 * Time: 13:11
 */

namespace App\Doctrination\Testing;

use Doctrine\DBAL\Connection;
use Illuminate\Foundation\Testing\DatabaseTransactions as EloquentDatabaseTransactions;

trait DatabaseTransactions
{

    use EloquentDatabaseTransactions;

    /**
     * @before
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

    /**
     * @return Doctrine\DBAL\Connection
     */
    protected function _getMockConnection()
    {
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