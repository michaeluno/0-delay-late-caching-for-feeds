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
class LateCachingForFeeds_SimplePie_Cache_Transient extends LateCachingForFeeds_SimplePie_Cache_Transient_Normal {

	/**
     * Returns the modification time of the cache.
     *
     * Make SimplePie think the cache is not expired yet while checking if it is expired.
     * And if yes, schedule a background routine to renew it.
	 * @access public
	 */
	public function mtime() {
	    // Debugging
        //LateCachingForFeeds_Debug::log(
        //    array(
        //        'is expired' => $this->___isExpired( get_option( '_transient_' . $this->mod_name ) ),
        //        'remained'   => time() - ( ( integer ) get_option( '_transient_' . $this->mod_name ) + ( integer ) $this->lifetime )
        //    )
        //);
        if ( $this->___isExpired( get_option( '_transient_' . $this->mod_name ) ) ) {
            $this->___scheduleBackgroundCacheRenewal();
        }
        return time() + ( integer ) $this->lifetime + 100;  // SimplePie would think it is not expired

	}
	    private function ___isExpired( $iTime ) {
	        // If the modification time is somehow gone, evaluate it as expired.
	        if ( ! $iTime ) {
	            return true;
            }
            return ( integer ) $iTime + ( integer ) $this->lifetime < time();
        }
        private function ___scheduleBackgroundCacheRenewal() {

	        $_aCacheNameMap = apply_filters( 'lcfs_filter_cache_name_map', array() );
	        if ( ! isset( $_aCacheNameMap[ $this->_sRawCacheName ] ) ) {
	            return;
            }
            LateCachingForFeeds_WPUtility::scheduleSingleWPCronTask(
                'lcff_action_renew_simplepie_cache',
                array(
                    $_aCacheNameMap[ $this->_sRawCacheName ], // the url
                    $this->name,
                    $this->mod_name,
                    $this->lifetime
                )
            );
	        // Load wp-cron.php in background
            add_action( 'shutdown', array( $this, 'replyToSpawnCron' ) );

        }
            public function replyToSpawnCron() {
	            static $_bLoaded = false;
	            if ( $_bLoaded ) {
	                return;
                }
                $_bLoaded = true;
                spawn_cron();
            }

    /**
     * Do not delete caches.
     *
     * SimplePie calls this method even though the cache is not found.
     * It causes a slight period of time between deleting and adding caches.
     * During that period, if the page gets loaded, fetching process is done in the
     * background and the front-end. In order to avoid that, do not delete the cache.
     * It will be deleted when it is overwritten or garbage-collected.
     *
     * @return false
     */
    public function unlink() {
   		return false;
   	}

}