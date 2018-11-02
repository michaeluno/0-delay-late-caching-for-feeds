<?php
/**
 * Manually include the bootstrap script as Codeception bootstrap runs after loading this file.
 * @see https://github.com/Codeception/Codeception/issues/862
 */
// include_once( dirname( dirname( __FILE__ ) ) . '/_bootstrap.php' );

/**
 * @group   wp
 */
class SimplePie_SettingMultipleURLs_Test extends \WPPlugin_UnitTestCase {
        
    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        parent::tearDown();
    }

    /**
     *
     */
    public function test_whetherFeedURLIsStored() {

        $_sFeedURL = site_url() . '/feed/rss2';
        $_oSubClassSetter = new LateCachingForFeeds_SimplePieSubClassSetter;
        fetch_feed( $_sFeedURL );

        $_aMap = $this->getObjectAttribute( $_oSubClassSetter, '___aCacheNameMap' );
        $this->assertTrue(
            in_array( $_sFeedURL, $_aMap )
        );

    }

    public function test_whetherMultipleFeedURLsAreStored() {

        $_sFeedURL1 = site_url() . '/feed/rss2?testing=1';
        $_sFeedURL2 = site_url() . '/feed/rss2?testing=2';
        $_aFeedURLs = array( $_sFeedURL1, $_sFeedURL2 );
        $_oSubClassSetter = new LateCachingForFeeds_SimplePieSubClassSetter;
        fetch_feed( $_aFeedURLs );

        $_aMap = $this->getObjectAttribute( $_oSubClassSetter, '___aCacheNameMap' );
        $this->assertTrue(
            in_array( $_sFeedURL1, $_aMap )
        );
        $this->assertTrue(
            in_array( $_sFeedURL2, $_aMap )
        );

    }


}
