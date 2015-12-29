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
    public function tag_workflow($tagCount)
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

        if ($tagCount > 0) {
            $this->assertTrue($article->removeTag($tag));
            $this->assertNotTrue($article->hasTag($tag));
            $this->assertCount($tagCount - 1, $article->getTags());
        }

        $anotherTag = new Tag('anotherTag');
        $this->assertFalse($article->removeTag($anotherTag));
    }

}