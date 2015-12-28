<?php
use App\Doctrination\Testing\DatabaseTransactions;

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

        $article = $repo->createOrUpdate(compact('title', 'body'));

        $this->assertInstanceOf('App\Doctrination\Entities\Article', $article);
        $this->assertEquals($title, $article->getTitle());
        $this->assertEquals($body, $article->getBody());
        $this->assertEmpty($article->getTags());
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