<?php


/**
 * Class mutationNoneTest
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing mutation 'filter'
 */
class mutationFilterTest extends WP_UnitTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \ue\mutation\filter;
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
    public function test_mutation_none_class_exists()
    {
        $this->assertIsObject($this->class_instance);
    }

    /**
     * @test
     *
     * @testdox Testing the config() method.
     *
     */
    public function test_config_method()
    {
        $input = 'config';

        $expected = null;

        $got = $this->class_instance->config($input);

        $this->assertEquals($expected, $got);
    }

    /**
     * @test
     *
     * @testdox Testing the in() method.
     *
     */
    public function test_in_method()
    {
        $input = 'test input';

        $this->class_instance->in($input);

        $expected = $input;

        $got = $this->class_instance->input;

        $this->assertEquals($expected, $got);
    }


    
    /**
     * @test
     *
     * This implements the run method on the process class.
     *
     * @testdox Testing the out() method
     *
     */
    public function test_out_method()
    {

        // Create dummy filter for the filter mutation tests
        add_filter('phpunit_dummy_filter', 'dummy_function', 10, 2);
        function dummy_function($args){ 
            return true; 
        }

        /**
         * Setup - Options
         * 
         * See the bootstrap file for the dummy filter 
         * being run.
         */
        $options = [
            'filter_name' => 'phpunit_dummy_filter',
            'filter_arguments' => [
                'first', 'second'
            ],
        ];
        $this->class_instance->config($options);

        /**
         * Expected, Recieved, Asserted
         */
        $expected = [ true ];

        $received = $this->class_instance->out();

        $this->assertEquals($expected, $received);
    }

}
