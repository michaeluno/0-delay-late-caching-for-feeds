<?php
/**
 * 0 Delay Late Caching for Feeds
 *
 * [PROGRAM_URI]
 * Copyright (c) 2018 Michael Uno
 *
 */

/**
 * Provides utility methods.
 */
class LateCachingForFeeds_Utility extends LateCachingForFeeds_AdminPageFramework_Utility {

    static public function getByteSize( $a ) {
        $_sString = is_scalar( $a )
            ? ( string ) $a
            : serialize( ( array ) $a );
        $_sMethod = function_exists( 'mb_strlen' ) ? 'mb_strlen' : 'strlen';
        return call_user_func_array( $_sMethod, array( $_sString, '8bit' ) );
    }

}