<?php

/**
 * Class mutationFfmpegProcessorTest
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing mutation 'FFMpeg Processor'.
 */
class mutationFfmpegProcessorTest extends WP_UnitTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \ue\mutation\ffmpeg_processor;
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
    public function util_make_post_with_videoID(int $number = 1)
    {
        for ($i = 0; $i < $number; $i++) {
            $in = (array) $this->factory->post->create_and_get();
            add_post_meta($in['ID'], 'videoId', 'dQw4w9WgXcQ');
            $this->input[$i] = array_merge($in, get_post_meta($in['ID']));
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
     */
    public function test_in_method()
    {
        $input = 'input';

        $result = $this->class_instance->in($input);

        $expected = null;

        $got = $result;

        $this->assertEquals($expected, $got);
    }
    

    /**
     * @test
     *
     * @testdox Testing the out() method with standard inputs
     *
     */
    public function test_out_method()
    {

        /**
         * Setup - Posts
         */
        $this->util_make_post_with_videoID(2);

        /**
         * Setup - config
         */
        $config = [
            'field_key' => 'videoId->0',
            'ffmpeg_steps' => [
                [
                    'enabled' => true,
                    'description' => 'phpunit test ffmpeg',
                    'ffmpeg_arguments' => ' -hide_banner -loglevel panic -n $inputs -filter_complex "[0:v] [0:a] [1:v] [1:a] concat=n=2:v=1:a=1 [v] [a]" -map "[v]" -map "[a]" -strict -2 $upload_dir/output.mp4',
                ]
            ],
            'collection' => [
                $this->input[0],
                $this->input[1],
            ],
        ];
        $this->class_instance->config($config);

        
        /**
         * Expected, Recieved, Asserted
         */
        $expected = [
            "/tmp/wordpress/wp-content/uploads/2020/12/dQw4w9WgXcQ_video.mp4",
            "/tmp/wordpress/wp-content/uploads/2020/12/dQw4w9WgXcQ_video.mp4",
            'output_file' => "/tmp/wordpress/wp-content/uploads/2020/12/output.mp4",
        ];

        $recieved = $this->class_instance->out();

        $this->assertEquals($expected, $recieved);
    }



    /**
     * @test
     *
     * @testdox Testing the out_collection() method with standard inputs
     *
     */
    public function test_out_collection_method()
    {

        /**
         * Setup - Posts
         */
        $this->util_make_post_with_videoID(2);

        /**
         * Setup - config
         */
        $config = [
            'field_key' => 'videoId->0',
            'ffmpeg_steps' => [
                [
                    'enabled' => true,
                    'description' => 'phpunit test ffmpeg',
                    'ffmpeg_arguments' => ' -hide_banner -loglevel panic -n $inputs -filter_complex "[0:v] [0:a] [1:v] [1:a] concat=n=2:v=1:a=1 [v] [a]" -map "[v]" -map "[a]" -strict -2 $upload_dir/output.mp4',
                ]
            ],
            'collection' => [
                $this->input[0],
                $this->input[1],
            ],
        ];
        $this->class_instance->config($config);


        /**
         * Expected, Recieved, Asserted
         */
        $expected = [
            "/tmp/wordpress/wp-content/uploads/2020/12/dQw4w9WgXcQ_video.mp4",
            "/tmp/wordpress/wp-content/uploads/2020/12/dQw4w9WgXcQ_video.mp4",
            'output_file' => "/tmp/wordpress/wp-content/uploads/2020/12/output.mp4",
        ];

        $recieved = $this->class_instance->out_collection();

        $this->assertEquals($expected, $recieved);
    }


    /**
     * @test
     *
     * @testdox Testing the out() method that is disabled.
     *
     */
    public function test_out_method_disabled()
    {

        /**
         * Setup - config
         */
        $config = [
            'field_key' => 'videoId->0',
            'ffmpeg_steps' => [
                [
                    'enabled' => false,
                    'description' => 'phpunit test ffmpeg',
                    'ffmpeg_arguments' => ' -hide_banner -loglevel panic -n $inputs -filter_complex "[0:v] [0:a] [1:v] [1:a] concat=n=2:v=1:a=1 [v] [a]" -map "[v]" -map "[a]" -strict -2 $upload_dir/output.mp4',
                ]
            ]
        ];
        $this->class_instance->config($config);
        
        /**
         * Expected, Recieved, Asserted
         */
        $expected = null;

        $recieved = $this->class_instance->out();

        $this->assertEquals($expected, $recieved);
    }

}
