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
     * @param array $serialized
     * @return \App\Models\Tries\Article
     */
    public function createOrUpdate(array $serialized)
    {
        $entityName = $this->getEntityName();

        if (isset($serialized['id'])) {
            $entity = $this->getEntityManager()->find($entityName, $serialized['id']);
        }

        if (!isset($entity)) {
            $entity = new $entityName();
        }

        foreach ($serialized as $key => $val) {
            $method = 'set' . ucfirst($key);
            if (method_exists($entity, $method)) {
                $entity->$method($val);
            }
        }
        return $entity;
    }

    /**
     * @param array $filterBy
     * @param int $perPage
     * @param string $pageName
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function filterBy(array $filterBy, $perPage = 5, $pageName = 'page')
    {
        $qb = $this->createQueryBuilder('a');

        if (isset($filterBy['body']) && !empty($filterBy['body'])) {
            $qb->andWhere($qb->expr()->like('a.body', ':body'))
                ->setParameter('body', '%' . $filterBy['body'] . '%');
        }
        if (isset($filterBy['title']) && !empty($filterBy['title'])) {
            $qb->andWhere($qb->expr()->like('a.title', ':title'))
                ->setParameter('title', '%' . $filterBy['title'] . '%');
        }

        return $this->paginate($qb->getQuery(), $perPage, $pageName);
    }


}