<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 28.12.15
 * Time: 13:11
 */

namespace App\Doctrination\Testing;

use Illuminate\Foundation\Testing\DatabaseTransactions as EloquentDatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;

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
     * @BeforeScenario
     *
     * @var $this TestCase
     */
    public function beginDatabaseTransaction()
    {
        $em = app('em');
        /** @var \Doctrine\ORM\EntityManager $em */
        $em->getConnection()->beginTransaction();

        if (method_exists($this, 'beforeApplicationDestroyed')) {
            $this->beforeApplicationDestroyed([$this, 'rollback']);
        }
    }

    /**
     * @AfterScenario
     */
    public function rollback()
    {
        $em = app('em');
        /** @var \Doctrine\ORM\EntityManager $em */
        $em->getConnection()->rollBack();
    }
}