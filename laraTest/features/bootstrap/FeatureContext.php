<?php

use App\Doctrination\Entities\Article;
use App\Doctrination\Repositories\ArticleRepository;
use App\Doctrination\Testing\DatabaseTransactions;
use App\Doctrination\Testing\EntityManagerTrait;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{

    use DatabaseTransactions;
    use EntityManagerTrait;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }


    /**
     * @When I follow :link on :page
     * @param string $link
     * @param string $page
     */
    public function iFollowOn($link, $page)
    {
        $this->visit($page);
        $this->clickLink($link);
    }

    /**
     * @Then /^the response should match "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function theResponseShouldMatch($regex)
    {
        $regex = '#' . str_replace('#', '\#', $regex) . '#ui';
        $this->assertSession()->responseMatches($this->fixStepArgument($regex));
    }

    /**
     * @Given there is an article:
     */
    public function thereIsAnArticle(TableNode $table)
    {
        $testArticle = $this->_getMockArticle($table);
        PHPUnit::assertInstanceOf(Article::class, $testArticle);
    }

    /**
     * EntityManager will return Article mock each time when it's searched by a given ID
     *
     * @param TableNode $table
     * @return Article
     */
    protected function _getMockArticle(TableNode $table)
    {
        $articleData = $table->getRowsHash();
        $article     = new Article($articleData['title'], $articleData['body']);
        $articleId   = $articleData['id'];

        $reflection          = new ReflectionClass($article);
        $reflection_property = $reflection->getProperty('id');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($article, $articleId);

        $this->_mockEntityManagerFacade(ArticleRepository::class, Article::class);
        EntityManager::shouldReceive('find')
            ->with(Article::class, $articleId)
            ->andReturn($article);

        return EntityManager::find(Article::class, $articleId);
    }
}
