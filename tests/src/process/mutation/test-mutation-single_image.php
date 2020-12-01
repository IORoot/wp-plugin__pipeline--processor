<?php


/**
 * Class mutationSingleImageTest
 *
 * @package Andyp_processor
 */

/**
 * @testdox Testing mutation 'Single Image'
 */
class mutationSingleImageTest extends WP_UnitTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new \ue\mutation\single_image;
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

        $this->class_instance->config($input);

        $expected = $input;

        $got = $this->class_instance->config;

        $this->assertEquals($expected, $got);
    }

    /**
     * @test
     *
     * @testdox Testing the in() method.
     * 
     * This will upload a test image and 
     *
     */
    public function test_in_method()
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
         * Set the config
         */
        $config['image']['url'] = $upload['url'];
        $this->class_instance->config($config);

        /** Run the in() */
        $this->class_instance->in('not used');

        /** What we uploaded */
        $expected = get_attached_file($id);

        /** What we inserted into the class */
        $got = $this->class_instance->input;

        $this->assertEquals($expected, $got);
    }



    /**
     * @test
     *
     * @testdox Testing out() returns the same as the input.
     *
     */
    public function test_out_method()
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
         * Set the config
         */
        $config['image']['url'] = $upload['url'];
        $this->class_instance->config($config);

        /** Run the in() */
        $this->class_instance->in('not used');

        /** Expect the path of the image */
        $expected = get_attached_file($id);

        /** Result of the out() method */
        $got = $this->class_instance->out();

        $this->assertEquals($expected, $got);
    }


    /**
     * @test
     *
     * @testdox Testing out_collection() returns the same as the input.
     *
     */
    public function test_out_collection_method()
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
         * Set the config
         */
        $config['image']['url'] = $upload['url'];
        $this->class_instance->config($config);

        /** Run the in() */
        $this->class_instance->in('not used');

        /** Expect the path of the image */
        $expected = get_attached_file($id);

        /** Result of the out() method */
        $got = $this->class_instance->out_collection();

        $this->assertEquals($expected, $got);
    }


    
}
