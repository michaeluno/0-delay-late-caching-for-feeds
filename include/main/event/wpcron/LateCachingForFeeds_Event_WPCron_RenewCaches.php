<?php
/**
 * Late Caching for Feeds
 *
 * [PROGRAM_URI]
 * Copyright (c) 2018 Michael Uno
 *
 */

/**
 *
 */
class LateCachingForFeeds_Event_WPCron_RenewCaches {

    public function __construct() {
        add_action( 'lcff_action_renew_simplepie_cache', 'fetch_feed' );
    }

}