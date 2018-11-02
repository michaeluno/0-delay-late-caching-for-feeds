<?php
/**
 * Late Caching for Feeds
 *
 * [PROGRAM_URI]
 * Copyright (c) 2018 Michael Uno
 *
 */

/**
 * Sets a custom sub-class for feed caches.
 */
class LateCachingForFeeds_SimplePieSubClassSetter extends LateCachingForFeeds_Utility {

    private $___aCacheNameMap = array(
        // 'cache name' => 'https:// ... ', url
    );

    public function __construct() {

        add_action( 'wp_feed_options', array( $this, 'replyToSetCustomSubclasses' ), 10, 2 );
        add_filter( 'lcfs_filter_cache_name_map', array( $this, 'replyToReturnCacheNameMap' ) );

    }

    /**
     * Sets a custom cache class.
     *
     * @param   SimplePie       $oFeed
     * @param   string|array    $asURL      URL(s)
     * @return void
     */
    public function replyToSetCustomSubclasses( $oFeed, $asURL ) {

        if ( ! $oFeed instanceof SimplePie ) {
            return;
        }

        $oFeed->set_cache_class( 'LateCachingForFeeds_SimplePie_Cache' );

        // Store the url in a cache name map so that the cache object later can refer to it.
        // Consider that the set url may be multiple.
        // If a single feed is set, it is stored in `$oFeed->feed_url`
        // for multiple, `$oFeed->multifeed_url`.
        foreach( $this->getAsArray( $asURL ) as $_sURL ) {
            $_sURL = trim( $_sURL );
            $_sCacheName = call_user_func( $oFeed->cache_name_function, $_sURL );
            $this->___aCacheNameMap[ $_sCacheName ] = $_sURL;
        }

    }

    /**
     * @param       array $aMap
     *
     * @return      array
     * @callback    filter      lcfs_filter_cache_name_map
     */
    public function replyToReturnCacheNameMap( array $aMap ) {
        return $this->___aCacheNameMap + $aMap;
    }

}