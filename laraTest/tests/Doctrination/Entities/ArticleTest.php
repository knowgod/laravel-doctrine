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
     * @test
     * @dataProvider provideTagsCount
     *
     * @param $tagCount
     */
    public function addTag_and_hasTag($tagCount)
    {
        $article = new Article();

        for ($i = 0; $i < $tagCount; ++$i) {
            $tag = new Tag(uniqid('testTag_'));
            $this->assertFalse($article->hasTag($tag));

            $article->addTag($tag);
            $this->assertTrue($article->hasTag($tag));
        }
        $this->assertContainsOnlyInstancesOf(Tag::class, $article->getTags());
        $this->assertCount($tagCount, $article->getTags());
    }

}