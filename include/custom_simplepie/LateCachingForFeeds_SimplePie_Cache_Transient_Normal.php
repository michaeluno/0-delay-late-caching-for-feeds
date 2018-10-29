<?php
/**
 * Late Caching for Feeds
 *
 * [PROGRAM_URI]
 * Copyright (c) 2018 Michael Uno
 *
 */

/**
 * Handles SimplePie feed caches.
 *
 * `WP_Feed_Cache_Transient` for background pages would also work
 * but it uses `get_transient()` and deletes the option right away when it is found expired.
 * And then fetches the source. During the fetching process, if the subject page is loaded in front-end,
 * since the cache is deleted, the SimplePie starts fetching the source again.
 * The same requests get performed twice, which is redundant.
 *
 * This class ensures that the cache won't get deleted while accessing the source.
 */
class LateCachingForFeeds_SimplePie_Cache_Transient_Normal extends WP_Feed_Cache_Transient {

    /**
     * Raw cache name
     * The transient name will have the `feed_` prefix added to it.
     */
    protected $_sRawCacheName = '';

    /**
   	 * Constructor.
   	 *
   	 * @param string $location  Cache directory.
   	 * @param string $filename  Unique identifier for cache object.
   	 * @param string $extension 'spi' or 'spc'.
   	 */
   	public function __construct( $location, $filename, $extension ) {
        $this->_sRawCacheName = $filename;
   	    parent::__construct( $location, $filename, $extension );
    }


    /**
     * Needs to return the cached data anyway.
     * `get_transient()` returns false if the data is expired so use `get_option()`.
     * @return mixed
     */
    public function load() {
        return get_option( '_transient_' . $this->name );
   	}

}