<?php

/**
 * Class mutationGeneratorImageTest
 * 
 * This class allows us to run another plugin:
 * the andyp_pipeline_generative_images.
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing mutation 'Generator Image'
 */
class mutationGeneratorImageTest extends WP_UnitTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \ue\mutation\generator_image;
    }

    public function tearDown() {
        $this->remove_added_uploads();
        parent::tearDown();
    }

    /**
     * Create a post, attachment and thumbnail.
     * 
     * int $number is the number of posts you want.
     */
    public $input;
    public function util_make_post_with_thumbnail(int $number = 1)
    {
        for ($i = 0; $i < $number; $i++) {
            $in['post']            = $this->factory->post->create_and_get();
            $in['attachment_id']   = $this->factory->attachment->create_upload_object( DIR_DATA . '/test_image.jpg', $in['post']->ID );
            $in['thumbnail']       = set_post_thumbnail( $in['post']->ID, $in['attachment_id'] );
            $in['post_attachment'] = get_attached_media( 'image', $in['post']->ID );
            $this->input[$i] = $in;
        }
    }


    /**
     * @test
     *
     * @testdox Testing class exists and returns an object.
     *
     */
    public function test_mutation_single_image_class_exists()
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

        $result = $this->class_instance->config($input);

        $expected = null;

        $got = $result;

        $this->assertEquals($expected, $got);
    }

    
    /**
     * @test
     *
     * @testdox Testing the in() method.
     * 
     * Does nothing.
     *
     */
    public function test_in_method()
    {
        $input = 'config';

        $result = $this->class_instance->in($input);

        $expected = null;

        $got = $result;

        $this->assertEquals($expected, $got);
    }

    
    /**
     * @test
     *
     * @testdox Testing the out_collection() method.
     * 
     * Does nothing.
     *
     */
    public function test_out_collection_method()
    {

        $expected = null;

        $got = $this->class_instance->out_collection();

        $this->assertEquals($expected, $got);
    }


    /**
     * @test
     *
     * @testdox Testing the out() method with single source images.
     * 
     * Filter Slug = corner_dots
     * Source Images = "This record field value"
     * SaveAs = jpg
     *
     */
    public function test_out_method_with_single_source_image()
    {

        /**
         * Setup - Create a post in db
         */
        $this->util_make_post_with_thumbnail();

        /**
         *  Setup - Generative Images - Source 'phpunit_test_source'
         */
        $source = [
            'genimage_source_slug' => 'phpunit_test_source',
            'genimage_source_type' => 'get_query',
            'genimage_post'        => null,
            'genimage_taxonomy'    => null,
            'genimage_query'       => "[
                'post_type' => 'post',
                'post_status' => 'publish',
                'numberposts' => 1,
            ]",
        ];
        $result1 = add_row('genimage_source', $source, 'option');



        /**
         * Setup - Generative Images - Filter group
         */
        $filter_group = [
            'genimage_filter_group' => [
                'genimage_filter_preview' => '',
                'genimage_filter_slug' => 'phpunit_generative_images_test',
            ],
            'genimage_filter_description' => 'testing generator image',
            'genimage_filter_resize_width' => null,
            'genimage_filter_resize_height' => null,
            'genimage_filter' => [
                [
                    'filter_name' => "image",
                    'filter_parameters' => 'filter="url(#phpunit)"',
                ],
                [
                    'filter_name' => "text",
                    'filter_parameters' => '<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" style="font-size: 42px; fill:#fafafa;" >PHPUNIT GENERATOR IMAGE FOR THE PROCESSOR</text>',
                ]
            ]
        ];
        $result2 = add_row('genimage_filters', $filter_group, 'option');



        /**
         * Setup -  config
         */
        $config = [
            'enabled'       => true,
            'filter_slug'   => 'phpunit_generative_images_test',
            'save_as'       => [ 'jpg' ],
            'image_width'   => '',
            'image_height'  => '',
            'images_array'  => [ 
                [ 'ID' => $this->input[0]['post']->ID ]
            ],
        ];

        $this->class_instance->config($config);

        $upload_dir = wp_upload_dir();
        $expected = [
            [
                "wp-content/uploads".$upload_dir['subdir']."/test_image_gi.jpg"
            ]
        ];

        $received = $this->class_instance->out();

        $this->assertEquals($expected, $received);
    }



    /**
     * @test
     *
     * @testdox Testing the out() method while disabled
     *
     */
    public function test_out_with_disabled_mutation()
    {

        /**
         * Setup -  config
         */
        $config = [
            'enabled'       => false,
            'filter_slug'   => 'phpunit_generative_images_test',
            'save_as'       => [ 'jpg' ],
            'image_width'   => '',
            'image_height'  => '',
            'images_array'  => [ 
                [ 'ID' => 1 ]
            ],
        ];

        $this->class_instance->config($config);

        $expected = null;

        $received = $this->class_instance->out();

        $this->assertEquals($expected, $received);
    }



    /**
     * @test
     *
     * @testdox Testing the out() method with no data
     *
     */
    public function test_out_with_no_data()
    {

        /**
         * Setup -  config
         */
        $config = [
            'enabled'       => true
        ];

        $this->class_instance->config($config);

        $expected = null;

        $received = $this->class_instance->out();

        $this->assertEquals($expected, $received);
    }


    /**
     * @test
     *
     * @testdox Testing the out() method with custom dimensions
     *
     */
    public function test_out_with_custom_dimensions()
    {

        /**
         * Setup -  config
         */
        $config = [
            'enabled'       => true,
            'image_width'   => '400',
            'image_height'  => '400',
        ];

        $this->class_instance->config($config);

        $expected = null;

        $received = $this->class_instance->out();

        $this->assertEquals($expected, $received);
    }
    
}
