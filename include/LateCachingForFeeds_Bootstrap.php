<?php
/**
 * 0 Delay Late Caching for Feeds
 *
 * [PROGRAM_URI]
 * Copyright (c) 2018 Michael Uno
 *
 */

/**
 * Loads the plugin components.
 */
class LateCachingForFeeds_Bootstrap {

    private $___sFilePath;

    public function __construct( $sFilePath ) {

        $this->___sFilePath = $sFilePath;
        $this->___load();

    }

        private function ___load() {

            if ( ! $this->___hasRequirements() ) {
                $this->___deactivate();
                return;
            }

            $this->___include();

            new LateCachingForFeeds_SimplePieSubClassSetter;
            new LateCachingForFeeds_Event_WPCron_RenewCaches;

        }
            private function ___include() {
                include( LateCachingForFeeds_Registry::$sDirPath . '/include/class-list.php' );
                LateCachingForFeeds_Registry::registerClasses( $_aClassFiles );
            }

            private function ___deactivate() {
                if ( ! is_admin() ) {
                    return;
                }
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                deactivate_plugins( $this->___sFilePath );
            }

            /**
             * @return bool
             */
            private function ___hasRequirements() {

                if ( class_exists( 'SimplePie' ) ) {
                    $_sMessage = sprintf(
                        '%1$s: ' . __( 'The SimplePie library is already loaded. This plugin cannot run.', 'late-caching-for-feeds' ),
                        LateCachingForFeeds_Registry::NAME
                    );
                    LateCachingForFeeds_Registry::setAdminNotice( $_sMessage, 'error' );
                    return false;
                }
                return true;

            }

}