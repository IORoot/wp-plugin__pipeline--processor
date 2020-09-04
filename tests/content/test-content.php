<?php

/**
 * Class contentTest
 *
 * @package Andyp_universal_exporter
 */

/**
 * @testdox Testing the \ue\content class
 */
class contentTest extends WP_UnitTestCase {
    
    // ┌─────────────────────────────────────────────────────────────────────────┐ 
    // │                                                                         │░
    // │                                                                         │░
    // │                         \ue\content class                               │░
    // │                                                                         │░
    // │                                                                         │░
    // └─────────────────────────────────────────────────────────────────────────┘░
    //  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
    
	/** 
	 * @test
     * 
	 */
	public function test_content_class_exists() {

        $got = new \ue\content;

		$this->assertIsObject($got);
    }

}
