<?php
/**
 * Late Caching for Feeds
 *
 * [PROGRAM_URI]
 * Copyright (c) 2018 Michael Uno
 *
 */

/**
 * Provides utility methods that uses WordPress functions.
 */
class LateCachingForFeeds_WPUtility extends LateCachingForFeeds_Utility {

    /**
     * Schedules a WP Cron single event.
     * @since       1.0.0
     * @return      boolean     True if scheduled (or already scheduled), false otherwise.
     */
    static public function scheduleSingleWPCronTask( $sActionName, array $aArguments, $iTime=0 ) {

        if ( wp_next_scheduled( $sActionName, $aArguments ) ) {
            return true;
        }
        $_bCancelled = wp_schedule_single_event(
            $iTime ? $iTime : time(), // now
            $sActionName,   // an action hook name which gets executed with WP Cron.
            $aArguments    // must be enclosed in an array. The callback function receives the parameters inside the most outer array.
        );
        return false !== $_bCancelled;

    }

}