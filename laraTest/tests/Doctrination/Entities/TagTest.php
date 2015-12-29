<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 29.12.15
 * Time: 13:28
 */

namespace Doctrination\Entities;


use App\Doctrination\Entities\Article;
use App\Doctrination\Entities\Tag;

class TagTest extends \TestCase
{

    public function provideArticleCount()
    {
        return [[0], [1], [2], [16]];
    }

    /**
     * @test
     * @dataProvider provideArticleCount
     *
     * @param $articleCount
     */
    public function article_workflow($articleCount)
    {
        $tag = new Tag("testTag_with_{$articleCount}_articles");

        for ($i = 0; $i < $articleCount; ++$i) {
            $article = new Article();
            $this->assertFalse($tag->hasArticle($article));

            $tag->addArticle($article);
            $this->assertTrue($tag->hasArticle($article));
        }
        $this->assertContainsOnlyInstancesOf(Article::class, $tag->getArticles());
        $this->assertCount($articleCount, $tag->getArticles());

        if ($articleCount > 0) {
            $this->assertTrue($tag->removeArticle($article));
            $this->assertNotTrue($tag->hasArticle($article));
            $this->assertCount($articleCount - 1, $tag->getArticles());
        }

        $anotherArticle = new Article();
        $this->assertFalse($tag->removeArticle($anotherArticle));
    }
}