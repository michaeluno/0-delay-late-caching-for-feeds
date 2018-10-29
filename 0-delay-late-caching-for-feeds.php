<?php
/**
 *	Plugin Name:    Late Caching for Feeds
 *	Plugin URI:     https://github.com/michaeluno/0-delay-late-caching-for-feeds
 *	Description:    Implements a late caching mechanism for the built-in WordPress RSS parser.
 *	Author:         Michael Uno (miunosoft)
 *	Author URI:     http://michaeluno.jp
 *	Version:        1.0.1
 */

/**
 * Provides the basic information about the plugin.
 *
 */
class LateCachingForFeeds_Registry_Base {
 
	const VERSION        = '1.0.1';    // <--- DON'T FORGET TO CHANGE THIS AS WELL!!
	const NAME           = 'Late Caching for Feeds';
	const DESCRIPTION    = 'Implements a late caching mechanism for the built-in WordPress RSS parser.';
	const URI            = 'http://en.michaeluno.jp/';
	const AUTHOR         = 'miunosoft (Michael Uno)';
	const AUTHOR_URI     = 'http://en.michaeluno.jp/';
	const PLUGIN_URI     = 'http://en.michaeluno.jp/';
	const COPYRIGHT      = 'Copyright (c) 2013-2018, Michael Uno';
	const LICENSE        = 'GPL v2 or later';
	const CONTRIBUTORS   = '';
 
}

// Do not load if accessed directly
if ( ! defined( 'ABSPATH' ) ) { 
    return; 
}

/**
 * Provides the common data shared among plugin files.
 * 
 * To use the class, first call the setUp() method, which sets up the necessary properties.
 * 
 * @package     Late Caching for Feeds
 * @copyright   Copyright (c) 2018, Michael Uno
 * @authorurl	http://michaeluno.jp
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
*/
final class LateCachingForFeeds_Registry extends LateCachingForFeeds_Registry_Base {
    
	const TEXT_DOMAIN               = 'late-caching-for-feeds';
	const TEXT_DOMAIN_PATH          = '/language';
    
    /**
     * The hook slug used for the prefix of action and filter hook names.
     * 
     * @remark      The ending underscore is not necessary.
     */    
	const HOOK_SLUG                 = 'lcff';    // without trailing underscore
    
    /**
     * The transient prefix. 
     * 
     * @remark      This is also accessed from uninstall.php so do not remove.
     * @remark      Up to 8 characters as transient name allows 45 characters or less ( 40 for site transients ) so that md5 (32 characters) can be added
     */    
	const TRANSIENT_PREFIX          = 'LCFF';

    /**
     *
     */
    static public $sFilePath = __FILE__;
    
    /**
     */    
    static public $sDirPath;

    /**
     * @var string
     */
    static public $sTempDirName = '';

    /**
     * @var array
     */
    static public $aOptionKeys = array(
    );
        
    /**
     * Used admin pages.
     */
    static public $aAdminPages = array(
        // key => 'page slug'
    );
    
    /**
     * Used post types.
     */
    static public $aPostTypes = array(
    );
    
    /**
     * Used post types by meta boxes.
     */
    static public $aMetaBoxPostTypes = array(
        // 'page'      => 'page',
        // 'post'      => 'post',
    );
    
    /**
     * Used taxonomies.
     */
    static public $aTaxonomies = array(
        // Used to be stored in the `TagSlug` class constant.
        // 'tag'   => 'taxonomy_slug',
    );
    
    /**
     * Used shortcode slugs
     */
    static public $aShortcodes = array(
        // 'key'  => 'my_short_code',
    );

    /**
     * Stores custom database table names.
     * @remark      The below is the structure
     * array(
     *      'slug (part of database wrapper class file name)' => array(
     *          'version'   => '0.1',
     *          'name'      => 'table_name',    // serves as the table name suffix
     *      ),
     *      ...
     * )
     */
    static public $aDatabaseTables = array(
//        'key' => array(
//            'name'              => 'some_name_key', // serves as the table name suffix
//            'version'           => '1.0.0',
//            'across_network'    => true,
//            'class_name'        => 'LateCachingForFeeds_DatabaseTable_some_name_key',
//        ),
    );

    /**
     * Sets up class properties.
     * @return      void
     */
	static function setUp() {
        self::$sDirPath  = dirname( self::$sFilePath );
	}

    /**
     * @return      string
     */
    static public function getPluginURL( $sRelativePath='' ) {
		return plugins_url( $sRelativePath, self::$sFilePath );
	}

    /**
     * Requirements.
     */    
    static public $aRequirements = array(
        'php' => array(
            'version'   => '5.2.4',
            'error'     => 'The plugin requires the PHP version %1$s or higher.',
        ),
        'wordpress'         => array(
            'version'   => '3.5',   // SimplePie 1.3.1
            'error'     => 'The plugin requires the WordPress version %1$s or higher.',
        ),
//        'mysql'             => array(
//            'version'   => '5.0.3', // uses VARCHAR(2083)
//            'error'     => 'The plugin requires the MySQL version %1$s or higher.',
//        ),
        'functions'     => '', // disabled
        // array(
            // e.g. 'mblang' => 'The plugin requires the mbstring extension.',
        // ),
        'classes'       => array(
//            'DOMDocument' => 'The plugin requires the DOMXML extension.',
        ),
        'constants'     => '', // disabled
        // array(
            // e.g. 'THEADDONFILE' => 'The plugin requires the ... addon to be installed.',
            // e.g. 'APSPATH' => 'The script cannot be loaded directly.',
        // ),
        'files'         => '', // disabled
        // array(
            // e.g. 'home/my_user_name/my_dir/scripts/my_scripts.php' => 'The required script could not be found.',
        // ),
    );

    static public $aAdminNotices = array();
    static public function setAdminNotice( $sMessage, $sType ) {
        self::$aAdminNotices[] = array( 'message' => $sMessage, 'type' => $sType );
        add_action( 'admin_notices', array( __CLASS__, 'replyToShowAdminNotices' ) );
    }
        static public function replyToShowAdminNotices() {
            foreach( self::$aAdminNotices as $_aNotice ) {
                $_sType = esc_attr( $_aNotice[ 'type' ] );
                echo "<div class='{$_sType}'>"
                     . "<p>" . $_aNotice[ 'message' ] . "</p>"
                     . "</div>";
            }
        }

    static public function registerClasses( array $aClasses ) {
        self::$___aAutoLoadClasses = $aClasses + self::$___aAutoLoadClasses;
        spl_autoload_register( array( __CLASS__, 'replyToLoadClass' ) );
    }
        static private $___aAutoLoadClasses = array();
        static public function replyToLoadClass( $sCalledUnknownClassName ) {
            if ( ! isset( self::$___aAutoLoadClasses[ $sCalledUnknownClassName ] ) ) {
                return;
            }
            include( self::$___aAutoLoadClasses[ $sCalledUnknownClassName ] );
        }

}
LateCachingForFeeds_Registry::setUp();

include( LateCachingForFeeds_Registry::$sDirPath . '/include/LateCachingForFeeds_Bootstrap.php' );
new LateCachingForFeeds_Bootstrap( LateCachingForFeeds_Registry::$sFilePath );


/* For testing */
//include( LateCachingForFeeds_Registry::$sDirPath . '/test/allow-sleep-query.php'  );
//include( LateCachingForFeeds_Registry::$sDirPath . '/test/set-short-feed-cache-duration.php'  );




