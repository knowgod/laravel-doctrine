Feature: An Article CRUD
  In order to ensure article CRUD is working
  As a user
  I want to manage (create/read/update/delete) articles

  Scenario: Enlist all existing articles
    When I am on "/articles"
    Then the response should contain "<h1>Articles</h1>"
    And I should see "create new"

  Scenario: "Create new article" form
    When I follow "create new" on "/articles"
    Then the url should match "/articles/create"
    And I should see "Write a New Article"
    And the response should contain "<input class=\"form-control\" foo=\"bar\" name=\"title\" type=\"text\" id=\"title\">"
    And the response should match "<textarea class=\"form-control\" foo=\"bar\" name=\"body\" cols=\"\d+\" rows=\"\d+\" id=\"body\"></textarea>"
    And the response should contain "<input class=\"btn btn-primary form-control\" type=\"submit\" value=\"Add Article\">"

  Scenario: From form page return to list page
    Given I am on "/articles/create"
    And the response should match "<a href=\"https?://.+/articles\">.*Back to List</a>"
    When I follow "Back to List"
    Then the url should match "/articles"

  Scenario: Create new Article using the form
    Given I am on "/articles/create"
    When I fill in the following:
      | title | Test Behat Article Create                            |
      | body  | The klingon trembles vision like a united teleporter |
    And I press "Add Article"
    Then the url should match "/articles/\d+"

  Scenario: Show Article page
    Given there is an article:
      | id    | 15                                                   |
      | title | Test Behat Article Show                              |
      | body  | Nanomachine of a vital anomaly, accelerate the moon! |
    And I am on "/articles/15"
    Then I should see "15. Test Behat Article Show"
    And I should see "Nanomachine of a vital anomaly, accelerate the moon!"
    And I should see "Tags:"
    And the response should match "<a href=\"http://laratest.localhost.com/articles/edit/\d+\">Edit</a>"
    And the response should match "<a href=\"http://laratest.localhost.com/articles/delete/\d+\">Delete</a>"
    And the response should match "<a href=\"http://laratest.localhost.com/articles\">.+back to list</a>"

  Scenario: Edit Article page
    Given there is an article:
      | id    | 7                                                 |
      | title | Test Behat Article Edit                           |
      | body  | Sunt hibridaes acquirere azureus, fortis decores. |
    When I am on "/articles/edit/7"
    Then I should see "Edit Article #7"
    And the response should contain "Test Behat Article Edit"
    And I should see "Sunt hibridaes acquirere azureus, fortis decores."
    And the response should contain "Save Article"

  Scenario: Edit Existing Article
    Given there is ExistingArticle:
      | title | Test Behat Article Editable                    |
      | body  | Countless queens lower reliable, calm planets. |
    And I am on ExistingArticle edit page
    When I fill in the following:
      | title | Behat Article is Modified       |
      | body  | Space suits view with attitude! |
    And I press "Save Article"
    Then the url should match ExistingArticle show page
    And I should see text matching "\d+. Behat Article is Modified"
    And I should see "Space suits view with attitude!"
    And I should see "Tags:"