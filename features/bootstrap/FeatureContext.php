<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

require_once __DIR__ . '/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

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
     * @Then I should see the expires header to a value in the future
     */
    public function iShouldSeeTheExpiresHeaderToAValueInTheFuture()
    {
        $rawExpires = $this->getSession()->getResponseHeader('expires');

        assertNotNull($rawExpires, 'I\'m not able to find an expires header!');

        $expires = DateTime::createFromFormat(DateTime::RFC1123, $rawExpires);

        assertGreaterThan(
            (new DateTime())->setTimezone(new DateTimeZone('GMT')),
            $expires,
            'The expires header is not set on the future'
        );
    }

    /**
     * @Then the cachecontrol header should include the public directive
     */
    public function itShouldBePublic()
    {
        $rawCacheControl = $this->getSession()->getResponseHeader('cache-control');

        assertNotNull($rawCacheControl, 'I\'m not able to find the cache-control header!');
        assertNotContains('private', $rawCacheControl, 'The cache-control header should not include the "private" directive!');
        assertContains('public', $rawCacheControl, 'The cache-control header should include the "public" directive!');
    }

    /**
     * @Then I should see the last modified header
     */
    public function iShouldSeeTheLastModifiedHeader()
    {
        $lastModified = $this->getSession()->getResponseHeader('last-modified');
        assertNotNull($lastModified, 'I\'m not able to find the last-modified header!');
        assertNotFalse(
            DateTime::createFromFormat(DateTime::RFC1123, $lastModified),
            'The last-modified header is not a valid RFC 1123 date'
        );
    }

    /**
     * @Then I should see an etag
     */
    public function iShouldSeeAnEtag()
    {
        assertNotNull(
            $this->getSession()->getResponseHeader('etag'),
            'I\'m not able to find the ETag header!'
        );
    }

    /**
     * @Then the cachecontrol header should include the maxage directive for private caches
     */
    public function theCachecontrolHeaderShouldIncludeTheMaxageDirectiveForPrivateCaches()
    {
        $rawCacheControl = $this->getSession()->getResponseHeader('cache-control');

        assertNotNull($rawCacheControl, 'I\'m not able to find the cache-control header!');
        assertContains('max-age', $rawCacheControl, 'The cache-control header should include the "max-age" directive!');
    }

    /**
     * @Then the cachecontrol header should include the shared maxage directive for shared caches
     */
    public function theCachecontrolHeaderShouldIncludeTheSharedMaxageDirectiveForSharedCaches()
    {
        $rawCacheControl = $this->getSession()->getResponseHeader('cache-control');

        assertNotNull($rawCacheControl, 'I\'m not able to find the cache-control header!');
        assertContains('s-maxage', $rawCacheControl, 'The cache-control header should include the "s-maxage" directive!');
    }
}
