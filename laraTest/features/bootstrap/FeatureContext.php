<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{

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

}
