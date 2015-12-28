<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 28.12.15
 * Time: 14:22
 */

namespace Doctrination\Entities;


use App\Doctrination\Entities\Article;
use App\Doctrination\Entities\Tag;

class ArticleTest extends \TestCase
{
    public function provideTagsCount()
    {
        return [[0], [1], [2], [16]];
    }

    /**
     * @dataProvider provideTagsCount
     *
     * @param $tagCount
     */
    public function testAddTag($tagCount)
    {
        $article = new Article();

        for ($i = 0; $i < $tagCount; ++$i) {
            $tag = new Tag(uniqid('testTag_'));
            $this->assertEmpty($tag->getArticle());

            $article->addTag($tag);
            $this->assertContainsOnlyInstancesOf('App\Doctrination\Entities\Tag', $article->getTags());
            $this->assertTrue($article->getTags()->contains($tag));
            $this->assertInstanceOf('App\Doctrination\Entities\Article', $tag->getArticle());
        }
        $this->assertCount($tagCount, $article->getTags());
    }

}