<?php


/**
 * Class mutationGeneratorImageTest
 * 
 * This class allows us to run another plugin:
 * the andyp_generative_images.
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
         * Create an image attachment
         */
        $filename = ( DIR_DATA . '/test_image.jpg' );
        $contents = file_get_contents( $filename );
        $upload = wp_upload_bits( wp_basename( $filename ), null, $contents );
        $this->assertTrue( empty( $upload['error'] ) );
        $id = $this->_make_attachment( $upload );

        /**
         * Create a post
         */
        $attached_file = get_post_meta( $id, '_wp_attached_file', true );
        $post = get_post( $id );

        /**
         * Set config
         */
        $config['enabled']      = true;
        $config['filter_slug']  = 'corner_dots';
        $config['save_as']      = [ 'jpg' ];        // array
        $config['image_width']  = '';
        $config['image_height'] = '';
        $config['images_array'] = [ 'ID' => $post->ID ];    // single ID.

        $this->class_instance->config($config);

        $result = $this->class_instance->out();

        $expected = null;

        $got = $result;

        $this->assertEquals($expected, $got);
    }


    
}
