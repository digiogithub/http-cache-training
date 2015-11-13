Feature: Performance
  In order to improve conversion over the web application
  As a owner of the web app
  I need the correct HTTP cache headers on each request

  Scenario: Playlist page should use the expiration cache model
    Given I am on the homepage
     When I go to "/playlists"
     Then I should see the expires header to a value in the future
      And the cachecontrol header should include the public directive
      And the cachecontrol header should include the maxage directive for private caches
      And the cachecontrol header should include the shared maxage directive for shared caches

  Scenario: Playlist tracks page should use the validation cahe model
    Given I am on the homepage
     When I go to "/playlists"
      And I follow "Grunge"
      And I reload the page
     Then I should see the last modified header
      And I should see an etag

  Scenario: Tracks details page should use a mix of validation and expiration cache models
    Given I am on the homepage
     When I go to "/playlists"
      And I follow "Grunge"
      And I follow "Man In The Box"
      And I reload the page
     Then I should see the expires header to a value in the future
      And the cachecontrol header should include the public directive
      And the cachecontrol header should include the maxage directive for private caches
      And the cachecontrol header should include the shared maxage directive for shared caches
      And I should see the last modified header
      And I should see an etag