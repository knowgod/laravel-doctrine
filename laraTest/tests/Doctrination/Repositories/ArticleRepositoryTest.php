<?php
use App\Doctrination\Entities\Article;
use App\Doctrination\Entities\Tag;
use App\Doctrination\Testing\DatabaseTransactions;
use LaravelDoctrine\ORM\Facades\EntityManager;

/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 25.12.15
 * Time: 18:08
 */
class ArticleRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @todo Need testUpdate method
     *
     */
    public function testCreate()
    {
        $em = app('em');
        /** @var \Doctrine\ORM\EntityManager $em */
        $repo = $em->getRepository(Article::class);
        /** @var App\Doctrination\Repositories\ArticleRepository $repo */
        $this->assertInstanceOf(\App\Doctrination\Repositories\ArticleRepository::class, $repo);

        $title = 'Sails rise with hunger.';
        $body  = 'Caesiums studere, tanquam camerarius lumen.';

        $tag = $this->_saveTags($title);

        $article = $repo->createOrUpdate(compact('title', 'body', 'tag'));

        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals($title, $article->getTitle());
        $this->assertEquals($body, $article->getBody());
        $this->assertCount(count($tag), $article->getTags());
    }

    /**
     * @param string $prefix
     * @return array
     */
    protected function _saveTags($prefix = 'testTag#0')
    {
        $aTags = [
            $prefix . '-1',
            $prefix . '-2',
            $prefix . '-3',
        ];

        $savedTags = [];
        foreach ($aTags as $tagName) {
            $tagEntity = new Tag($tagName);
            EntityManager::persist($tagEntity);
            $savedTags[] = $tagEntity;
        }
        EntityManager::flush();

        return array_map(
            function (Tag $oTag) {
                return $oTag->getId();
            },
            $savedTags
        );
    }

}