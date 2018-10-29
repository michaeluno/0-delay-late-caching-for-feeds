=== 0 Delay Late Caching for Feeds ===
Contributors:       Michael Uno, miunosoft
Donate link:        http://en.michaeluno.jp/donate
Tags:               feeds, feed, rss, rss2, atom, caching, caches, cache, late cache, late caching, speed, page load,
Requires at least:  3.5
Requires PHP:       5.2.4
Tested up to:       4.9.8
Stable tag:         1.0.0
License:            GPLv2 or later
License URI:        http://www.gnu.org/licenses/gpl-2.0.html

Implements a late caching mechanism for the built-in WordPress RSS parser.

== Description ==

= What is Late Caching? = 

Have you ever felt that a page having RSS feeds loads relatively slow when it renews their caches?

The current implementation of the WordPress built-in feed caching mechanism renews the cache during the page load when it is expired. When this happens, it takes some time to load while the server accesses the external feed source. This is noticeable for site visitors in most cases and they may leave the site unless they are patient enough.

What this plugin does is to put off the refresh process and to make it done later in the background process.

Immediate Caching (WordPress Built-in Default Mechanism):

 1. A page loads and detects a feed is expired.
 2. Fetches new contents of the feed.
 3. Displays them.

The step 2 above takes time and noticeable to the viewer.

Late Caching:

 1. A page loads and detects a feed is expired.
 2. Schedules a cache renewal event in the background.
 3. Displays the expired contents.
 4. The cache gets renewed in the background and the updated contents are displayed in the next page load.

== Installation ==

= Install =
1. Upload **`0-delay-late-caching-for-feeds.php`** and other files compressed in the zip folder to the **`/wp-content/plugins/`** directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.

= Getting Started = 
1. Only activation is required to run this plugin.

== Frequently asked questions ==

= What happens when a feed is loaded for the first time? =

For the first time of loading, it fetches the contents normally and rerun them after that. 

== Other Notes ==

= Reserved =

= 1.0.0 - 2018/10/30 =
- Released initially.