<?php

        
/**
 * Class combineTest
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing the \ue\save class
 */
class saveTest extends WP_UnitTestCase
{



    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \ue\save;
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
            'ue_job_save_id' => []
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

        $collection = ['ue\mappings' => ''];

        $return = $this->class_instance->set_collection($collection);

        $expected = null;

        $got = $return;

        $this->assertEquals($expected, $got );

    }




    /** 
	 * @test
     * 
     * @testdox Testing the run() method to save a post
     * 
	 */
	public function test_run_to_save_a_post() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\mappings' => [
                [
                    'post' => [
                        'post_title' => 'Title One'
                    ]
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);


        /**
         * Setup - Options
         */
        $options = [
            'ue_job_save_id' => [
                'ue_save_group' => [
                    'ue_save_enabled' => true,
                    'ue_save_id' => "PHPUnit Save Test",
                ],
                'ue_save_posttype' => 'exporter',
                'ue_save_taxonomy' => 'exportercategory',
                'ue_save_taxonomy_term' => 'phpunit',
            ]
        ];
        $this->class_instance->set_options($options);

        $run = $this->class_instance->run();

        /**
         * Expected, Received, Asserted
         */
        $expected = 'Title One';

        $received = $run['post']['post_title'];

        $this->assertEquals($expected, $received );

    }




    /** 
	 * @test
     * 
     * @testdox Testing the run() method to save a metafield
     * 
	 */
	public function test_run_to_create_metadata() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\mappings' => [
                [
                    'meta' => [
                        'metafield_phpunit' => 'Metafield One'
                    ]
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);


        /**
         * Setup - Options
         */
        $options = [
            'ue_job_save_id' => [
                'ue_save_group' => [
                    'ue_save_enabled' => true,
                    'ue_save_id' => "PHPUnit Save Test",
                ],
                'ue_save_posttype' => 'exporter',
                'ue_save_taxonomy' => 'exportercategory',
                'ue_save_taxonomy_term' => 'phpunit',
            ]
        ];
        $this->class_instance->set_options($options);

        $run = $this->class_instance->run();

        /**
         * Expected, Received, Asserted
         */
        $expected = 'Metafield One';

        $received = $run['post']['metafield_phpunit'][0];

        $this->assertEquals($expected, $received );

    }

    /** 
	 * @test
     * 
     * @testdox Testing the run() method to save a new post and metafield
     * 
	 */
	public function test_run_to_create_new_post_and_add_meta() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\mappings' => [
                [
                    'post' => [
                        'post_title' => 'Post Title'
                    ],
                    'meta' => [
                        'metafield_phpunit' => 'Metafield One'
                    ]
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);


        /**
         * Setup - Options
         */
        $options = [
            'ue_job_save_id' => [
                'ue_save_group' => [
                    'ue_save_enabled' => true,
                    'ue_save_id' => "PHPUnit Save Test",
                ],
                'ue_save_posttype' => 'exporter',
                'ue_save_taxonomy' => 'exportercategory',
                'ue_save_taxonomy_term' => '',
            ]
        ];
        $this->class_instance->set_options($options);

        $run = $this->class_instance->run();

        /**
         * Expected, Received, Asserted
         */
        $expected1 = 'Post Title';

        $received1 = $run['post']['post_title'];

        $this->assertEquals($expected1, $received1);

        $expected2 = 'Metafield One';

        $received2 = $run['post']['metafield_phpunit'][0];

        $this->assertEquals($expected2, $received2);

    }



    /** 
	 * @test
     * 
     * @testdox Testing the run() method to save an image
     * 
	 */
	public function test_run_to_create_post_with_image() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\mappings' => [
                [
                    'post' => [
                        'post_title' => 'Post Title',
                        'post_status' => 'publish',
                    ],
                    'image' => [
                        'path' => DIR_DATA.'/test_image.jpg',
                    ]
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);


        /**
         * Setup - Options
         */
        $options = [
            'ue_job_save_id' => [
                'ue_save_group' => [
                    'ue_save_enabled' => true,
                    'ue_save_id' => "PHPUnit Save Test",
                ],
                'ue_save_posttype' => 'exporter',
                'ue_save_taxonomy' => 'exportercategory',
                'ue_save_taxonomy_term' => 'phpunit_test',
            ]
        ];
        $this->class_instance->set_options($options);

        $run = $this->class_instance->run();

        /**
         * Expected, Received, Asserted
         */
        $expected = $run['post']['_thumbnail_id'][0];

        $received = $run['image']['ID'];

        $this->assertEquals($expected, $received);

    }


    /** 
	 * @test
     * 
     * @testdox Testing the run() method to save an image with no path
     * 
	 */
	public function test_run_to_create_post_with_image_with_no_path() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\mappings' => [
                [
                    'post' => [
                        'post_title' => 'Post Title',
                        'post_status' => 'publish',
                    ],
                    'image' => [
                        'path' => ''
                    ]
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);


        /**
         * Setup - Options
         */
        $options = [
            'ue_job_save_id' => [
                'ue_save_group' => [
                    'ue_save_enabled' => true,
                    'ue_save_id' => "PHPUnit Save Test",
                ],
                'ue_save_posttype' => 'exporter',
                'ue_save_taxonomy' => 'exportercategory',
                'ue_save_taxonomy_term' => 'phpunit_test',
            ]
        ];
        $this->class_instance->set_options($options);

        $run = $this->class_instance->run();

        /**
         * Expected, Received, Asserted
         */
        $expected = false;

        $received = array_key_exists('image', $run);

        $this->assertEquals($expected, $received);

    }




    /** 
	 * @test
     * 
     * @testdox Testing the run() method to not save an image that's disabled
     * 
	 */
	public function test_run_to_create_post_while_disabled() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\mappings' => [
                [
                    'post' => [
                        'post_title' => 'Post Title',
                        'post_status' => 'publish',
                    ],
                    'image' => [
                        'path' => ''
                    ]
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);


        /**
         * Setup - Options
         */
        $options = [
            'ue_job_save_id' => [
                'ue_save_group' => [
                    'ue_save_enabled' => false,
                    'ue_save_id' => "PHPUnit Save Test",
                ],
                'ue_save_posttype' => 'exporter',
                'ue_save_taxonomy' => 'exportercategory',
                'ue_save_taxonomy_term' => 'phpunit_test',
            ]
        ];
        $this->class_instance->set_options($options);

        $run = $this->class_instance->run();

        /**
         * Expected, Received, Asserted
         */
        $expected = null;

        $received = $run;

        $this->assertEquals($expected, $received);

    }


    /** 
	 * @test
     * 
     * @testdox Testing the run() method without taxonomy
     * 
	 */
	public function test_run_without_taxonomy() {

        /**
         * Setup - Collection
         */
        $collection = [
            'ue\mappings' => [
                [
                    'post' => [
                        'post_title' => 'Post Title',
                        'post_status' => 'publish',
                    ],
                    'image' => [
                        'path' => DIR_DATA.'/test_image.jpg',
                    ]
                ]
            ]
        ];
        $this->class_instance->set_collection($collection);


        /**
         * Setup - Options
         */
        $options = [
            'ue_job_save_id' => [
                'ue_save_group' => [
                    'ue_save_enabled' => true,
                    'ue_save_id' => "PHPUnit Save Test",
                ],
                'ue_save_posttype' => 'exporter',
                'ue_save_taxonomy' => '',
                'ue_save_taxonomy_term' => 'phpunit_test',
            ]
        ];
        $this->class_instance->set_options($options);

        $run = $this->class_instance->run();

        /**
         * Expected, Received, Asserted
         */
        $expected = $run['post']['_thumbnail_id'][0];

        $received = $run['image']['ID'];

        $this->assertEquals($expected, $received);

    }

}
