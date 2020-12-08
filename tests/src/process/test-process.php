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
                    'ue_process_enabled' => true,
                    'ue_process_id' => "process testing for phpunit"
                ],
                'ue_process_collection' => [
                    [
                        'ue_mutation_input_select' => 'post_title',
                        'ue_process_method' => 'record',
                        'ue_mutation_stack_mutation_stack' => [
                            [
                                'acf_fc_layout' => 'uppercase',
                                'enabled' => true,
                            ]
                        ]
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
        $post1 = $this->factory->post->create_and_get(array( 'post_title' => 'Test Post 1' ));
        $post2 = $this->factory->post->create_and_get(array( 'post_title' => 'Test Post 2' ));
        $posts = [$post1, $post2];
        $this->class_instance->set_collection($posts);

        $expected = count($posts);

        $got = count($this->class_instance->collection);

        $this->assertEquals($expected, $got);
    }

    /**
     * @test
     *
     * This implements the run() method on the process class.
     *
     * @testdox Testing the run() method to loop over each record
     *
     */
    public function test_run_as_a_loop_on_each_record()
    {
        /**
         * Setup - Options
         */
        $options = [
            'ue_job_process_id' => [
                'ue_process_group' => [
                    'ue_process_enabled' => true,
                    'ue_process_id' => "process testing for phpunit"
                ],
                'ue_process_collection' => [
                    [
                        'ue_mutation_input_select' => 'post_title',
                        'ue_process_method' => 'record',
                        'ue_mutation_stack_mutation_stack' => [
                            [
                                'acf_fc_layout' => 'uppercase',
                                'enabled' => true,
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->class_instance->set_options($options);


        /**
         * Setup - Collection
         */
        $posts[] = (array) $this->factory->post->create_and_get(array( 'post_title' => 'Test Post 1' ));
        $posts[] = (array) $this->factory->post->create_and_get(array( 'post_title' => 'Test Post 2' ));

        $content = [
            'ue\\content' => $posts
        ];

        $this->class_instance->set_collection($content);



        /**
         * Expected, Recieved, Asserted
         */
        $expected = [
            [ 'post_title' => "TEST POST 1" ],
            [ 'post_title' => "TEST POST 2" ],
        ];

        $received = $this->class_instance->run();

        $this->assertEquals($expected, $received);
    }


    /**
     * @test
     *
     * This implements the run method on the process class.
     *
     * @testdox Testing the run() method with a single collection.
     *
     */
    public function test_run_as_a_collection()
    {
        /**
         * Setup - Options
         */
        $options = [
            'ue_job_process_id' => [
                'ue_process_group' => [
                    'ue_process_enabled' => true,
                    'ue_process_id' => "process testing for phpunit"
                ],
                'ue_process_collection' => [
                    [
                        'ue_mutation_input_select' => 'post_title',
                        'ue_process_method' => 'collection',
                        'ue_mutation_stack_mutation_stack' => [
                            [
                                'acf_fc_layout' => 'uppercase',
                                'enabled' => true,
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->class_instance->set_options($options);


        /**
         * Setup - Collection
         */
        $posts[] = (array) $this->factory->post->create_and_get(array( 'post_title' => 'Test Post 1' ));
        $posts[] = (array) $this->factory->post->create_and_get(array( 'post_title' => 'Test Post 2' ));

        $content = [
            'ue\\content' => $posts
        ];

        $this->class_instance->set_collection($content);

        /**
         * Expected, Recieved, Asserted
         */
        $expected = [
            [ 'post_title' => "TEST POST 1" ],
            [ 'post_title' => null ],
        ];

        $received = $this->class_instance->run();

        $this->assertEquals($expected, $received);
    }


    
    /**
     * @test
     *
     * This implements the run method on the process class.
     *
     * @testdox Testing the run() method with an array in the arguments and moustaches
     *
     */
    public function test_run_with_arguments_as_array_with_moustaches()
    {


        // Create dummy filter for the filter mutation tests
        add_filter('phpunit_dummy_filter_two', 'dummy_function_two', 10, 2);
        function dummy_function_two($args){ 
            return true; 
        }

        /**
         * Setup - Options
         * 
         * See the bootstrap file for the dummy filter 
         * being run.
         */
        $options = [
            'ue_job_process_id' => [
                'ue_process_group' => [
                    'ue_process_enabled' => true,
                    'ue_process_id' => "process testing for phpunit"
                ],
                'ue_process_collection' => [
                    [
                        'ue_mutation_input_select' => 'post_title',
                        'ue_process_method' => 'collection',
                        'ue_mutation_stack_mutation_stack' => [
                            [
                                'acf_fc_layout' => 'filter',
                                'enabled' => true,
                                'filter_name' => 'phpunit_dummy_filter_two',
                                'filter_arguments' => "[
                                    'first', '{{field_key}}'
                                ]",
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->class_instance->set_options($options);


        /**
         * Setup - Collection
         */
        $posts[] = (array) $this->factory->post->create_and_get();

        $content = [
            'ue\\content' => $posts
        ];

        $this->class_instance->set_collection($content);

        /**
         * Expected, Recieved, Asserted
         */
        $expected = [
            [
                'post_title_0' => true,
            ]
        ];

        $received = $this->class_instance->run();

        $this->assertEquals($expected, $received);
    }

}
