Feature:
  In order to implement Star Wars thematic
  As a Star Wars fan
  I want to see Start Wars page


  Scenario: Star wars page
    When I am on "/starwars"
    Then I should see "Death Star"

  Scenario: Luke's' squadron
    Given I am "Luke Skywalker"
    And there are 7 "Tie Fighter"
    When I have 5 "X-Wing"
    Then I should win