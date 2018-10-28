<?php
/**
 * 0 Delay Late Caching for Feeds
 *
 * [PROGRAM_URI]
 * Copyright (c) 2018 Michael Uno
 *
 */

/**
 * Sets a custom class for cache objects.
 */
class LateCachingForFeeds_SimplePie_Cache extends SimplePie_Cache {

    static private $___aBackgroundPages = array( 'admin-ajax.php', 'wp-cron.php' );

    /**
     * Create a new SimplePie_Cache object
     *
     * @static
     * @access public
     */
    public function create( $location, $filename, $extension ) {
        $_sClass = in_array( $GLOBALS[ 'pagenow' ], self::$___aBackgroundPages )
            ? 'LateCachingForFeeds_SimplePie_Cache_Transient_Normal'
            : 'LateCachingForFeeds_SimplePie_Cache_Transient';
        return new $_sClass( $location, $filename, $extension );
    } 
    
}