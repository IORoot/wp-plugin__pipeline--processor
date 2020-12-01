<?php


/**
 * Class processCollectionTest
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing the \ue\process_collection class
 */
class processCollectionTest extends WP_UnitTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \ue\process_collection;
    }

    public function tearDown()
    {
        $this->remove_added_uploads();
        parent::tearDown();
    }
    
    /**
     * @test
     *
     * @testdox Testing class exists and returns an object.
     *
     */
    public function test_process_collection_class_exists()
    {
        $this->assertIsObject($this->class_instance);
    }

    
}
