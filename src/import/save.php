<?php

namespace ue;

use \ue\import\exists;
use \ue\import\taxonomy;
use \ue\import\post;
use \ue\import\image;
use \ue\import\meta;
use \ue\import\attach;

class save
{
    /**
     * variables containing import objects.
     *
     * @var object
     */
    public $taxonomy;

    public $post;

    public $image;

    public $meta;

    public $attach;
    
    /**
     * options variable
     * 
     * Contains all of the "save" options for this instance.
     *
     * @var array
     */
    public $options;

    /**
     * collection variable
     * 
     * Contains all the results of each stage of the
     * universal exporter process.
     *
     * @var array
     */
    public $collection;

    /**
     * results variable
     *
     * What will be placed into the $collection
     * array once this stage is complete.
     * 
     * @var array
     */
    public $results;

    private $post_part_key;
    private $post_part_value;


    public function __construct()
    {
        $this->taxonomy = new taxonomy;

        $this->post = new post;

        $this->image = new image;

        $this->meta = new meta;

        $this->attach = new attach;

    }



    public function set_options($options)
    {
        $this->options = $options['ue_job_save_id'];
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }

    public function run()
    {
        $this->loop_over_mappings();
        return $this->results;
    }


//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                                                                         │░
//  │                                                                         │░
//  │                                 PRIVATE                                 │░
//  │                                                                         │░
//  │                                                                         │░
//  └─────────────────────────────────────────────────────────────────────────┘░
//   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░



    /**
     * loop_over_mappings function
     *
     * 0 => [
     *          post => [
     *                      post_title : "The title"
     *                      post_content : "The content"
     *                  ]
     *          meta => [
     *                      videoID : "abc123"
     *                      rankmath_title : "The title"
     *                  ]
     *          image => [
     *                      url : "abc123.jpg"
     *                      filename : "The title"
     *                      post_title : "The title"
     *                  ]
     *      ]
     * 
     * @return void
     */
    private function loop_over_mappings()
    {
        foreach($this->collection['ue\mappings'] as $this->post_key => $this->post_value )
        {
            $this->loop_over_post_parts();
        }
    }


    /**
     * loop_over_post_parts function
     * 
     *  post => [
     *              post_title : "The title"
     *              post_content : "The content"
     *          ]
     *  meta => [
     *              videoID : "abc123"
     *              rankmath_title : "The title"
     *          ]
     *  image => [
     *              url : "abc123.jpg"
     *              filename : "The title"
     *              post_title : "The title"
     *          ]
     * 
     * 
     * $post_part_key = post | meta | image
     * $post_part_value = post_args
     *
     * @return void
     */
    private function loop_over_post_parts()
    {
        $this->create_post();
        $this->attach_image();
        
    }



    private function create_post()
    {
        $this->post->set_args($this->post_value['post']);
        $this->post->add();
        $this->results['post'] = $this->post->result();
    }


    private function attach_image()
    {
        $this->image->set_args($this->post_value['image']);
        $this->image->set_postid($this->results['post']);
        $this->image->add();
        $this->results['image'] = $this->image->result();
    }



}