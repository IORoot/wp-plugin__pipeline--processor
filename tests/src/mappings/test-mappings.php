<?php

        
/**
 * Class combineTest
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing the \ue\mapping class
 */
class mappingTest extends WP_UnitTestCase
{



    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \ue\mappings;
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
     * @testdox Testing the set_options() method
     * 
	 */
	public function test_set_options() {

        $options = [
            'ue_job_mapping_id' => []
        ];

        $return = $this->class_instance->set_options($options);

        $expected = null;

        $got = $return;

        $this->assertEquals($expected, $got );

    }



	/** 
	 * @test
     * 
     * @testdox Testing the set_collection() method
     * 
	 */
	public function test_set_collection() {

        $collection = ['ue\combine' => ''];

        $return = $this->class_instance->set_collection($collection);

        $expected = null;

        $got = $return;

        $this->assertEquals($expected, $got );

    }




    /** 
	 * @test
     * 
     * @testdox Testing the run() method on a POST
     * 
	 */
	public function test_run_method_on_a_post() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\combine' => [
                [
                    '0_post_title' => 'Title One',
                    '1_post_title' => 'Title Two',
                    '2_post_title' => 'Title Three',
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);

        /**
         * Setup - Options
         */
        $options = [
            'ue_job_mapping_id' => [
                'ue_mapping_group' => [
                    'ue_mapping_enabled' => true,
                    'ue_mapping_id' => "PHPUnit Mapping Test",
                ],
                'ue_mapping_collection' => [
                    [
                        'ue_mapping_template' => '{{0_post_title}} and {{1_post_title}} and {{2_post_title}}',
                        'ue_mapping_destination' => 'post',
                        'ue_mapping_post_field' => 'post_title',
                        'ue_mapping_meta_field' => '',
                        'ue_mapping_image_field' => '',
                    ]
                ]
            ]
        ];
        $this->class_instance->set_options($options);


        /**
         * Expected, Received, Asserted
         */
        $expected = [
            [
                'post' => [
                    'post_title' => 'Title One and Title Two and Title Three'
                ]
            ]
        ];

        $received = $this->class_instance->run();

        $this->assertEquals($expected, $received );

    }


    /** 
	 * @test
     * 
     * @testdox Testing the run() method on a METAPOST
     * 
	 */
	public function test_run_method_on_metapost() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\combine' => [
                [
                    '0_post_title' => 'Title One',
                    '1_post_title' => 'Title Two',
                    '2_post_title' => 'Title Three',
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);

        /**
         * Setup - Options
         */
        $options = [
            'ue_job_mapping_id' => [
                'ue_mapping_group' => [
                    'ue_mapping_enabled' => true,
                    'ue_mapping_id' => "PHPUnit Mapping Test",
                ],
                'ue_mapping_collection' => [
                    [
                        'ue_mapping_template' => '{{0_post_title}} and {{1_post_title}} and {{2_post_title}}',
                        'ue_mapping_destination' => 'meta',
                        'ue_mapping_post_field' => '',
                        'ue_mapping_meta_field' => 'phpunit_test',
                        'ue_mapping_image_field' => '',
                    ]
                ]
            ]
        ];
        $this->class_instance->set_options($options);


        /**
         * Expected, Received, Asserted
         */
        $expected = [
            [
                'meta' => [
                    'phpunit_test' => 'Title One and Title Two and Title Three'
                ]
            ]
        ];

        $received = $this->class_instance->run();

        $this->assertEquals($expected, $received );

    }

    /** 
	 * @test
     * 
     * @testdox Testing the run() method on a METAPOST with {{Date:Y}} moustache
     * 
	 */
	public function test_run_method_on_metapost_with_date() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\combine' => [
                [
                    '0_post_title' => 'Title One',
                    '1_post_title' => 'Title Two',
                    '2_post_title' => 'Title Three',
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);

        /**
         * Setup - Options
         */
        $options = [
            'ue_job_mapping_id' => [
                'ue_mapping_group' => [
                    'ue_mapping_enabled' => true,
                    'ue_mapping_id' => "PHPUnit Mapping Test",
                ],
                'ue_mapping_collection' => [
                    [
                        'ue_mapping_template' => '{{0_post_title}} and {{1_post_title}} and {{2_post_title}} on {{date:Y}}',
                        'ue_mapping_destination' => 'meta',
                        'ue_mapping_post_field' => '',
                        'ue_mapping_meta_field' => 'phpunit_test',
                        'ue_mapping_image_field' => '',
                    ]
                ]
            ]
        ];
        $this->class_instance->set_options($options);


        /**
         * Expected, Received, Asserted
         */
        $expected = [
            [
                'meta' => [
                    'phpunit_test' => 'Title One and Title Two and Title Three on '.date('Y')
                ]
            ]
        ];

        $received = $this->class_instance->run();

        $this->assertEquals($expected, $received );

    }

    /** 
	 * @test
     * 
     * @testdox Testing the run() method on an IMAGE
     * 
	 */
	public function test_run_method_on_image() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\combine' => [
                [
                    '0_post_title' => 'Title One',
                    '1_post_title' => 'Title Two',
                    '2_post_title' => 'Title Three',
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);

        /**
         * Setup - Options
         */
        $options = [
            'ue_job_mapping_id' => [
                'ue_mapping_group' => [
                    'ue_mapping_enabled' => true,
                    'ue_mapping_id' => "PHPUnit Mapping Test",
                ],
                'ue_mapping_collection' => [
                    [
                        'ue_mapping_template' => '{{0_post_title}} and {{1_post_title}} and {{2_post_title}} on {{date:Y}}',
                        'ue_mapping_destination' => 'image',
                        'ue_mapping_post_field' => '',
                        'ue_mapping_meta_field' => '',
                        'ue_mapping_image_field' => 'phpunit_image_test',
                    ]
                ]
            ]
        ];
        $this->class_instance->set_options($options);


        /**
         * Expected, Received, Asserted
         */
        $expected = [
            [
                'image' => [
                    'phpunit_image_test' => 'Title One and Title Two and Title Three on '.date('Y')
                ]
            ]
        ];

        $received = $this->class_instance->run();

        $this->assertEquals($expected, $received );

    }

}
