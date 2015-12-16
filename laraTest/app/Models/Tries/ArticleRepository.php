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

}