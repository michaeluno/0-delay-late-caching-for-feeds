Late Caching for Feeds
===
Implements a late caching mechanism for the built-in WordPress RSS parser.

## What is Late Caching? 

Have you ever felt that a page having RSS feeds loads relatively slow when it renews their caches?

The current implementation of the WordPress built-in feed caching mechanism renews the cache during the page load when it is expired. When this happens, it takes some time to load while the server accesses the external feed source. This is noticeable for site visitors in most cases and they may leave the site unless they are patient enough.

What this plugin does is to put off the refresh process and to make it done later in the background process.

#### Immediate Caching (WordPress Built-in Default Mechanism):

1. A page loads and detects a feed is expired.
2. Fetches new contents of the feed.
3. Displays them.

The step 2 above takes time and noticeable to the viewer.

#### Late Caching:

1. A page loads and detects a feed is expired.
2. Schedules a cache renewal event in the background.
3. Displays the expired contents.
4. The cache gets renewed in the background and the updated contents are displayed in the next page load.

## Usage
Just activate the plugin. 

## License
[GPL v2 or later](./license.txt).