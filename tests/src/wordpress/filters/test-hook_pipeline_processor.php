<?php


/**
 * Class hookPipelineProcessorTest
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing the \filter\pipeline_processor class
 */
class hookPipelineProcessorTest extends WP_UnitTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \filter\pipeline_processor;
    }

    public function tearDown()
    {
        $this->remove_added_uploads();
        parent::tearDown();
    }
    
    public function mock_job(){
        return [
            'ue_job_group' => [
                'ue_job_enabled' => true,
                'ue_job_id' => 'phpunit_job_1',
            ],
            'ue_job_content_id'   => 'phpunit_content_1',
            'ue_job_process_id'   => 'phpunit_process_1',
            'ue_job_combine_id'   => 'phpunit_combine_1',
            'ue_job_mapping_id'   => 'phpunit_mapping_1',
            'ue_job_save_id'      => 'phpunit_save_1',
            'ue_job_housekeep_id' => 'phpunit_housekeep_1',
            'ue_job_schedule_id'  => 'phpunit_schedule_1',
        ];
    }
    
    public function mock_content(){
        return [
            'ue_content_group' => [
                'ue_content_enabled' => true,
                'ue_content_id' => 'phpunit_content_1',
            ],
            'ue_content_input' => 'query',
            'ue_content_query' => "[
                'post_type' => 'post',
                'numberposts' => 1,
            ]",
            'ue_content_posts' => false
        ];
    }
    
    public function mock_process(){
        return [
            'ue_process_group' => [
                'ue_process_enabled' => true,
                'ue_process_id' => 'phpunit_process_1',
            ],
            'ue_process_collection' => [
                [
                    'ue_mutation_input_select' => 'post_title',
                    'ue_mutation_method' => 'record',
                    'ue_mutation_stack_mutation_stack' => [
                        [
                            'acf_fc_layout' => 'none',
                            'enabled' => true,
                            'description' => 'title',
                        ]
                    ],
                ]
            ]
        ];
    }
    
    public function mock_combine(){
        return [
            'ue_combine_group' => [
                'ue_combine_enabled' => true,
                'ue_combine_id' => 'phpunit_combine_1',
            ],
            'ue_process_combine' => 'combine',
            'ue_combine_collection' => [
                [
                    'ue_combine_input_select' => 'post_title',
                    'ue_combine_method' => 'all',
                ]
            ],
            
        ];
    }
    
    public function mock_mapping(){
        return [
            'ue_mapping_group' => [
                'ue_mapping_enabled' => true,
                'ue_mapping_id' => 'phpunit_mapping_1',
            ],
            'ue_mapping_collection' => [
                [
                    'ue_mapping_template' => 'Title 1 should be: {{0_post_title}}',
                    'ue_mapping_destination' => 'post',
                    'ue_mapping_post_field' => 'post_title',
                    'ue_mapping_meta_field' => '',
                    'ue_mapping_image_field' => '',
                ],
                [
                    'ue_mapping_template' => 'publish',
                    'ue_mapping_destination' => 'post',
                    'ue_mapping_post_field' => 'post_status',
                    'ue_mapping_meta_field' => '',
                    'ue_mapping_image_field' => '',
                ]
            ],
        ];
    }
    
    public function mock_save(){
        return [
            'ue_save_group' => [
                'ue_save_enabled' => true,
                'ue_save_id' => 'phpunit_save_1',
            ],
            'ue_save_posttype' => 'exporter',
            'ue_save_taxonomy' => 'exportercategory',
            'ue_save_taxonomy_term' => 'phpunit_test_term',
        ];
    }
    
    public function mock_housekeep(){
        return [
            'ue_housekeep_group' => [
                'ue_housekeep_enabled' => true,
                'ue_housekeep_id' => 'phpunit_housekeep_1',
            ],
            'ue_housekeep_action' => 'none',
            'ue_housekeep_query' => '',
        ];
    }
    
    public function mock_schedule(){
        return [
            'ue_schedule_group' => [
                'ue_schedule_enabled' => true,
                'ue_schedule_id' => 'phpunit_schedule_1',
            ],
            'ue_schedule_list' => [
                [
                    'schedule' => [
                        'schedule_label' => 'phpunit_schedule_event_1',
                        'ue_schedule_repeats' => '1hour',
                    ],
                    'ue_schedule_starts' => date('U')
                ],
                
            ],
        ];
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
     * @testdox Testing the filter can be run.
     * s
	 */
	public function test_run_filter() {

        /**
         * Setup - Insert Post and Thumbnail.
         */
        $att_id = $this->factory->attachment->create_object([
            'file'        => DIR_DATA.'/test_image.jpg',
            'meta_input' => [
                '_wp_attachment_metadata' => [''],
            ]
        ]);
        $post = $this->factory->post->create_and_get([
            'meta_input' => [
                '_thumbnail_id' => $att_id,
            ]
        ]);

        /**
         * Setup - Job
         */
        add_row('ue_job_instance', $this->mock_job(), 'option');

        /**
         *  Setup - Content
         */
        add_row('ue_content_instance', $this->mock_content(), 'option');

        /**
         *  Setup - Process
         */
        add_row('ue_process_instance', $this->mock_process(), 'option');

        /**
         *  Setup - combine
         */
        add_row('ue_combine_instance', $this->mock_combine(), 'option');

        /**
         *  Setup - mapping
         */
        add_row('ue_mapping_instance', $this->mock_mapping(), 'option');

        /**
         *  Setup - Save
         */
        add_row('ue_save_instance', $this->mock_save(), 'option');

        /**
         *  Setup - Housekeep
         */
        add_row('ue_housekeep_instance', $this->mock_housekeep(), 'option');

        /**
         *  Setup - Schedule
         */
        add_row('ue_schedule_instance', $this->mock_schedule(), 'option');
        
        /**
         * Run filter.
         */
        $return = apply_filters('pipeline_processor', 'phpunit_job_1');

        /**
         * Expected, Received, Asserted
         */
        $expected = 19;

        $received = strpos($return['ue\\save']['post']['post_title'], $post->post_title);

        $this->assertEquals($expected, $received );

    }

}