<?php
/**
 * 0 Delay Late Caching for Feeds
 *
 * [PROGRAM_URI]
 * Copyright (c) 2018 Michael Uno
 *
 */

/**
 * Sets a custom sub-class for feed caches.
 */
class LateCachingForFeeds_SimplePieSubClassSetter {

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
     * @param  $oFeed    SimplePie
     * @return void
     */
    public function replyToSetCustomSubclasses( $oFeed, $sURL ) {

        if ( ! $oFeed instanceof SimplePie ) {
            return;
        }

        $oFeed->set_cache_class( 'LateCachingForFeeds_SimplePie_Cache' );

        // Store the url in a cache name map so that the cache object later can refer to it.
        $_sCacheName = call_user_func( $oFeed->cache_name_function, $oFeed->feed_url );
        $this->___aCacheNameMap[ $_sCacheName ] = $oFeed->feed_url;

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