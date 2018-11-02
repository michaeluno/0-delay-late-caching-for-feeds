<?php

/*
 $this->assertEquals()
$this->assertContains()
$this->assertFalse()
$this->assertTrue()
$this->assertNull()
$this->assertEmpty()
*/

class LateCachingForFeeds_RegistryTest extends \Codeception\Test\Unit {

    public function testGetPluginURL() {

    }

    public function testSetAdminNotice() {

    }

    public function testSetUp() {

        LateCachingForFeeds_Registry::$sDirPath = '';

        LateCachingForFeeds_Registry::setUp();
        $this->assertEquals(
            dirname( LateCachingForFeeds_Registry::$sFilePath ),
            LateCachingForFeeds_Registry::$sDirPath
        );

    }

    public function testReplyToShowAdminNotices() {

    }

    public function testRegisterClasses() {

        $_aClassFiles = $this->getStaticAttribute( 'LateCachingForFeeds_Registry', '___aAutoLoadClasses' );
        LateCachingForFeeds_Registry::registerClasses( $_aClassFiles );
        $this->assertAttributeEquals( $_aClassFiles , '___aAutoLoadClasses', 'LateCachingForFeeds_Registry' );

        $_aClassFiles = array( 'SomeClass' => 'SomeClass.php' );
        LateCachingForFeeds_Registry::registerClasses( $_aClassFiles );
        $this->assertAttributeNotEquals(
            $_aClassFiles ,
            '___aAutoLoadClasses',
            'LateCachingForFeeds_Registry'
        );

        $this->assertArrayHasKey(
            'SomeClass',
            $this->getStaticAttribute( 'LateCachingForFeeds_Registry', '___aAutoLoadClasses' ),
            'The key just set does not exist.'
        );

    }

    public function testReplyToLoadClass() {

        $this->assertFalse(
            class_exists( 'JustAClass' ),
            'The JustAClass class must not exist at this stage.'
        );
        include( codecept_root_dir() . '/tests/include/class-list.php' );
        LateCachingForFeeds_Registry::registerClasses( $_aClassFiles );
        $this->assertTrue(
            class_exists( 'JustAClass' ),
            'The class auto load failed with the LateCachingForFeeds_Registry::registerClasses() method.'
        );

    }

}
