<?php

namespace Tests\Doctrination;

use TestCase;

class ArticleControllerTest extends TestCase
{

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

        $articleData = [
            'title' => 'Test Article #' . date('Ymd_His'),
            'body'  => 'A falsis, repressor noster diatria. Est dexter capio, cesaris.',
        ];

        $this->visit('/articles/create')
            ->type($articleData['title'], 'title')
            ->type($articleData['body'], 'body')
            ->press('Add Article');

        $this->seePageIsRegex('/articles/\d+')
            ->see($articleData['title'])
            ->see($articleData['body']);
    }

    public function seePageIsRegex($uri)
    {
        $this->assertPageLoaded($uri);

        $this->assertRegExp("#{$uri}#", $this->currentUri, "Did not land on expected page [{$uri}].\n");

        return $this;
    }
}
