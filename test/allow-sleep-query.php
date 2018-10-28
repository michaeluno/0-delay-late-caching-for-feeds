<?php
// Access the feed url of the site itself with the `sleep` query like https://my-site/feed/rss2?sleep=3
// This simulates a slow feed.
if ( isset( $_GET[ 'sleep' ] ) ) {
    sleep( $_GET[ 'sleep' ] );
}
