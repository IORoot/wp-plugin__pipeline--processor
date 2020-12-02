<?php

/**
 * Class mutationYtdlFfmpegTest
 * 
 * This class allows us to run another plugin:
 * the andyp_pipeline_generative_images.
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing mutation 'YouTube Downloader' using the andyp_youtube_downloader
 */
class mutationYtdlFfmpegTest extends WP_UnitTestCase
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
    
}
