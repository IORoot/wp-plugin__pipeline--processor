<?php


/**
 * Class processTest
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing the \ue\process class
 */
class processTest extends WP_UnitTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \ue\process;
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
     * This implements the set_options method on the process class.
     *
     * @testdox Testing the set_options() method.
     *
     */
    public function test_process_set_options()
    {
        $options = [
            'ue_job_process_id' => [
                'ue_process_group' => [
                    'ue_process_enabled' => false,
                    'ue_process_id' => "process testing for phpunit"
                ],
                'ue_process_collection' => [
                    [
                        'ue_mutation_input_select' => 'post_title',
                        'ue_process_method' => 'record',
                        'ue_mutation_stack_mutation_stack' => false
                    ]
                ]
            ]
        ];

        $this->class_instance->set_options($options);

        $expected = $options['ue_job_process_id'];

        $got = $this->class_instance->options;

        $this->assertEquals($expected, $got);
    }


    /**
     * @test
     *
     * This implements the set_collections method on the process class.
     *
     * @testdox Testing the set_collection() method.
     *
     */
    public function test_process_set_collection()
    {
        $posts = $this->factory->post->create_many(2);

        $this->class_instance->set_collection($posts);

        $expected = count($posts);

        $got = count($this->class_instance->collection);

        $this->assertEquals($expected, $got);
    }
}
