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
        $this->class_instance = new \ue\mutation\ytdl_ffmpeg;
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
        $input = 'config';

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
            'enabled'                   => true,
            'youtube_video_code'        => 'YlE1LindMxE',
            'video_seek_start_point'    => '00:00:00',
            'video_seek_duration'       => '00:00:03',
            'override'                  => true,
        ];
        $this->class_instance->config($config);

        /**
         * Note, the 'url' will NOT be tested
         * against because we cannot accurately
         * predict what the YouTube url will be since it
         * will change.
         */
        $expected = [
            'itag'              => 22,
            'format'            => "mp4, video, 720p, audio",
            'ext'               => "mp4",
            'res'               => "720p",
            'path'              => "/tmp/wordpress/wp-content/uploads/2020/12",
            'filename'          => "/tmp/wordpress/wp-content/uploads/2020/12/YlE1LindMxE_video.mp4",
            'ffmpeg_installed'  => true
        ];

        $recieved = $this->class_instance->out();

        /** Cannot accurately predict this. */
        unset($recieved['url']);

        $this->assertEquals($expected, $recieved);
    }
    


    /**
     * @test
     *
     * @testdox Testing the out() method with disabled on
     *
     */
    public function test_out_while_disabled()
    {
        /**
         * Setup - config
         */
        $config = [
            'enabled'                   => false,
            'youtube_video_code'        => 'YlE1LindMxE',
            'video_seek_start_point'    => '00:00:00',
            'video_seek_duration'       => '00:00:03',
            'override'                  => true,
        ];
        $this->class_instance->config($config);

        /**
         * Note, the 'url' will NOT be tested
         * against because we cannot accurately
         * predict what the YouTube url will be since it
         * will change.
         */
        $expected = null;

        $recieved = $this->class_instance->out();

        /** Cannot accurately predict this. */
        unset($recieved['url']);

        $this->assertEquals($expected, $recieved);
    }




    /**
     * @test
     *
     * @testdox Testing the out_collection() method with standard inputs
     * 
     * Does nothing.
     *
     */
    public function test_out_collection_method()
    {

        $this->util_make_post_with_videoID(2);
        
        /**
         * Setup - config
         */
        $config = [
            'enabled'                   => true,
            'collection'                => $this->input,
            'youtube_video_code'        => 'YlE1LindMxE',
            'video_seek_start_point'    => '00:00:00',
            'video_seek_duration'       => '00:00:03',
            'override'                  => true,
            'field_key'                 => 'videoId->0',
        ];
        $this->class_instance->config($config);

        /**
         * Note, the 'url' will NOT be tested
         * against because we cannot accurately
         * predict what the YouTube url will be since it
         * will change.
         */
        $expected = [
            [
                'itag'              => 18,
                'format'            => "mp4, video, 360p, audio",
                'ext'               => "mp4",
                'res'               => "360p",
                'path'              => "/tmp/wordpress/wp-content/uploads/2020/12",
                'filename'          => "/tmp/wordpress/wp-content/uploads/2020/12/dQw4w9WgXcQ_video.mp4",
                'ffmpeg_installed'  => true
            ],
            [
                'itag'              => 18,
                'format'            => "mp4, video, 360p, audio",
                'ext'               => "mp4",
                'res'               => "360p",
                'path'              => "/tmp/wordpress/wp-content/uploads/2020/12",
                'filename'          => "/tmp/wordpress/wp-content/uploads/2020/12/dQw4w9WgXcQ_video.mp4",
                'ffmpeg_installed'  => true
            ],
        ];

        $recieved = $this->class_instance->out_collection();

        /** Cannot accurately predict this. */
        unset($recieved[0]['url']);
        unset($recieved[1]['url']);

        $this->assertEquals($expected, $recieved);
    }
    
}
