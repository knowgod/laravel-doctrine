<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 15.12.15
 * Time: 17:57
 */

namespace App\Models\Tries;


use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class ArticleRepository extends EntityRepository
{
    use Paginatable;

    /**
     * Create related entity
     *
     * @todo Implement Entity Update
     *
     * @param array $serialized
     * @return \App\Models\Tries\Article
     */
    public function createOrUpdate(array $serialized)
    {
        $entityName = $this->getEntityName();
        $entity     = new $entityName();

        foreach ($serialized as $key => $val) {
            $method = 'set' . ucfirst($key);
            if (method_exists($entity, $method)) {
                $entity->$method($val);
            }
        }
        return $entity;
    }
}