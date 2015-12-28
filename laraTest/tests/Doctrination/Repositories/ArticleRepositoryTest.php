<?php
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
     * @dataProvider provideArticleSource
     *
     * @param $title
     * @param $body
     */
    public function testCreateOrUpdate($title, $body)
    {
        $em = app('em');
        /** @var \Doctrine\ORM\EntityManager $em */
        $repo = $em->getRepository('App\Doctrination\Entities\Article');
        /** @var App\Doctrination\Repositories\ArticleRepository $repo */
        $this->assertEquals('App\Doctrination\Repositories\ArticleRepository', get_class($repo));

        $tag = $this->_saveTags($title);

        $article = $repo->createOrUpdate(compact('title', 'body', 'tag'));

        $this->assertInstanceOf('App\Doctrination\Entities\Article', $article);
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

    /**
     * @return array
     */
    public function provideArticleSource()
    {
        return [
            [
                'Sails rise with hunger.',
                'Caesiums studere, tanquam camerarius lumen.'
            ],
            [
                'Masts whine with booty.',
                'Fluctuss messis, tanquam fortis historia.'
            ],
        ];
    }
}