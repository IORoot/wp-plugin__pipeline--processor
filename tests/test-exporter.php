<?php

/**
 * Class exporterTest
 *
 * @package Andyp_universal_exporter
 */

/**
 * @testdox Testing the \ue\exporter class
 */
class exporterTest extends WP_UnitTestCase {
    
    // ┌─────────────────────────────────────────────────────────────────────────┐ 
    // │                                                                         │░
    // │                                                                         │░
    // │                         \ue\exporter class                              │░
    // │                                                                         │░
    // │                                                                         │░
    // └─────────────────────────────────────────────────────────────────────────┘░
    //  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
    
	/** 
	 * @test
     * 
	 */
	public function test_exporter_class_exists() {

        $got = new \ue\exporter;

		$this->assertIsObject($got);
    }

}
