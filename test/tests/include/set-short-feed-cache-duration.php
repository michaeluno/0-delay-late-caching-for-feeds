<?php
function test_return_60( $seconds ) {
    return 60;
}
add_filter( 'wp_feed_cache_transient_lifetime' , 'test_return_60' );
