<?php


use App\Doctrination\Entities\Article;
use App\Doctrination\Testing\DatabaseTransactions;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ArticleControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testList()
    {
        $this->visit('/articles')
            ->see('Articles')
            ->click('create new')
            ->seePageIs('/articles/create');
    }

    public function testCreate()
    {
        $this->visit('/articles/create')
            ->see('Write a New Article')
            ->see('Back to List')
            ->click('Back to List')
            ->seePageIs('/articles');

        $articleData = $this->_getArticleData();

        $this->visit('/articles/create')
            ->type($articleData['title'], 'title')
            ->type($articleData['body'], 'body')
            ->press('Add Article');

        $this->seePageIsRegex('/articles/\d+')
            ->see($articleData['title'])
            ->see($articleData['body']);
    }

    /**
     * @return array
     */
    protected function _getArticleData()
    {
        return [
            'title' => 'Test Article #' . date('Ymd_His'),
            'body'  => 'A falsis, repressor noster diatria. Est dexter capio, cesaris.',
        ];
    }

    /**
     * @see $this::seePageIs()
     *
     * @param $uri
     * @return $this
     */
    public function seePageIsRegex($uri)
    {
        $this->assertPageLoaded($uri);

        $this->assertRegExp("#{$uri}#", $this->currentUri, "Did not land on expected page [{$uri}].\n");

        return $this;
    }

    public function testShow()
    {
        $articleData = $this->_getArticleData();
        $testArticle = new Article($articleData['title'], $articleData['body']);
        $articleId   = 15;

        $this->_mockEntityManagerFacade();
        EntityManager::shouldReceive('find')
            ->with(Article::class, $articleId)
            ->andReturn($testArticle);

        $this->visit('/articles/' . $articleId)
            ->see($articleData['title'])
            ->see($articleData['body']);
    }
}
