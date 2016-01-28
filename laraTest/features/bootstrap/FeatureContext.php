<?php

use App\Doctrination\Entities\Article;
use App\Doctrination\Repositories\ArticleRepository;
use App\Doctrination\Testing\DatabaseTransactions;
use App\Doctrination\Testing\EntityManagerTrait;
use App\Doctrination\Testing\EntityTrait;
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
    use EntityManagerTrait, EntityTrait;

    /**
     * For usage in methods those apply 'ExistingArticle' word
     *
     * @var integer
     */
    protected $_existingArticleId;

    protected $_character;

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
        $article     = $this->_getEntityWithData(Article::class, $articleData);

        $this->_mockEntityManagerFacade(ArticleRepository::class, Article::class);

        EntityManager::shouldReceive('find')
            ->with(Article::class, $articleData['id'])
            ->andReturn($article);

        return EntityManager::find(Article::class, $articleData['id']);
    }

    /**
     * @Then there is no ExistingArticle
     */
    public function thereIsNoExistingArticle()
    {
        PHPUnit::assertGreaterThan(0, $this->_existingArticleId);
        $article = EntityManager::find(Article::class, $this->_existingArticleId);
        PHPUnit::assertEmpty($article);
    }

    /**
     * @Given there is ExistingArticle:
     */
    public function thereIsExistingArticle(TableNode $table)
    {
        $articleData = $table->getRowsHash();
        $article     = $this->_getEntityWithData(Article::class, $articleData);
        /** @var Article $article */

        EntityManager::persist($article);
        EntityManager::flush();

        PHPUnit::assertGreaterThan(0, $article->getId());
        $this->_existingArticleId = $article->getId();
    }

    /**
     * @Given I am on ExistingArticle show page
     * @When I follow ExistingArticle show page
     */
    public function iAmOnExistingArticleShowPage()
    {
        PHPUnit::assertGreaterThan(0, $this->_existingArticleId);
        $this->visit('/articles/' . $this->_existingArticleId);
    }

    /**
     * @Given I am on ExistingArticle edit page
     */
    public function iAmOnExistingArticleEditPage()
    {
        PHPUnit::assertGreaterThan(0, $this->_existingArticleId);
        $this->visit('/articles/edit/' . $this->_existingArticleId);
    }

    /**
     * @Then the url should match ExistingArticle show page
     */
    public function theUrlShouldMatchExistingArticleShowPage()
    {
        PHPUnit::assertGreaterThan(0, $this->_existingArticleId);
        $this->visit('/articles/' . $this->_existingArticleId);
    }

    /**
     * @Given I am :name
     */
    public function iAm($name)
    {
        $this->_character = $name;
        $characterPage    = strtolower(str_replace(' ', '', $name));
        $this->visit('/starwars/' . $characterPage);
    }

    /**
     * @When there are :count :item
     * @When I have :count :item
     */
    public function thereAre($item, $count)
    {
        $this->assertPageMatchesText('#(' . $item . '.*){' . $count . '}#');
    }

    /**
     * @Then I should win
     */
    public function iShouldWin()
    {
        $this->assertPageContainsText($this->_character . ' wins');
    }

}
