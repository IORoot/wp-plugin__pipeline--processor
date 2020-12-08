<?php

        
/**
 * Class combineTest
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing the \ue\combine class
 */
class combineTest extends WP_UnitTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \ue\combine;
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
    public function test_process_class_exists()
    {
        $this->assertIsObject($this->class_instance);
    }


	/** 
	 * @test
     * 
     * @testdox Testing the set_collection() method
     * 
	 */
	public function test_set_collection() {

        $input = "collection";

        $return = $this->class_instance->set_collection($input);

        $expected = null;

        $got = $return;

        $this->assertEquals($expected, $got );

    }


	/** 
	 * @test
     * 
     * @testdox Testing the set_options() method
     * 
	 */
	public function test_set_options() {

        $options = [
            'ue_job_combine_id' => []
        ];

        $return = $this->class_instance->set_options($options);

        $expected = null;

        $got = $return;

        $this->assertEquals($expected, $got );

    }

	/** 
	 * @test
     * 
     * @testdox Testing the run() method keeping records individual
     * 
	 */
	public function test_run_method_to_keep_records_individual() {

        /**
         * Setup - Collection 2 posts
         */
        $posts[] = (array) $this->factory->post->create_and_get();
        $posts[] = (array) $this->factory->post->create_and_get();
        $this->class_instance->set_collection($posts);

        /**
         * Setup - Options
         */
        $options = [
            'ue_job_combine_id' => [
                'ue_combine_group' => [
                    'ue_combine_enabled' => true,
                    'ue_combine_id' => "PHPUnit Combine Test",
                ],
                'ue_process_combine' => 'seperate',
                'ue_combine_collection' => false
            ]
        ];
        $this->class_instance->set_options($options);

        /**
         * Expected, Received, Asserted
         */
        $expected = null;

        $received = $this->class_instance->run();

        $this->assertEquals($expected, $received );

    }

}
