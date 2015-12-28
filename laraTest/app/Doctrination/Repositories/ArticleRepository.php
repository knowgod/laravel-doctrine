<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 15.12.15
 * Time: 17:57
 */

namespace App\Doctrination\Repositories;


use App\Doctrination\Entities\Article;
use Doctrine\ORM\EntityRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class ArticleRepository extends EntityRepository
{
    use Paginatable;

    /**
     * Create related entity
     *
     * @param array $serialized
     * @return Article
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
     * @return LengthAwarePaginator
     */
    public function filterBy($filterBy, $perPage = 5, $pageName = 'page')
    {
        $qb = $this->createQueryBuilder('a');

        if (is_array($filterBy)) {
            if (isset($filterBy['body']) && !empty($filterBy['body'])) {
                $qb->andWhere($qb->expr()->like('a.body', ':body'))
                    ->setParameter('body', '%' . $filterBy['body'] . '%');
            }
            if (isset($filterBy['title']) && !empty($filterBy['title'])) {
                $qb->andWhere($qb->expr()->like('a.title', ':title'))
                    ->setParameter('title', '%' . $filterBy['title'] . '%');
            }
        }

        return $this->paginate($qb->getQuery(), $perPage, $pageName);
    }


}