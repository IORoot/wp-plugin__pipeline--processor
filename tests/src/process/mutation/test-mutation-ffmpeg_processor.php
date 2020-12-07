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
         * Setup - config
         */
        $config = [
            'ffmpeg_steps' => [
            ],
        ];
        $this->class_instance->config($config);


        $recieved = $this->class_instance->out();

        /** Cannot accurately predict this. */
        unset($recieved['url']);

        $this->assertEquals($expected, $recieved);
    }

}
