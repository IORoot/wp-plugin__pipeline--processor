<?php

namespace ue;

use \ue\import\exists;
use \ue\import\taxonomy;
use \ue\import\post;
use \ue\import\image;
use \ue\import\attach;
use \ue\import\realmedia;

class save
{

    use debug;

    /**
     * variables containing import objects.
     *
     * @var object
     */
    public $taxonomy;

    public $post;

    public $image;

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

        $this->attach = new attach;

        $this->realmedia = new realmedia;

    }



    public function set_options($options)
    {
        $this->options = $options['ue_job_save_id'];
    }

    public function set_collection($collection)
    {
        $this->collection = $collection['ue\mappings'];
    }

    public function run()
    {
        if ($this->is_disabled()){ return; }
        $this->loop_over_mappings();
        $this->get_result_objects();
        $this->debug('save', $this->results);
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
        foreach($this->collection as $this->post_key => $this->post_value )
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
        $this->attach_meta();
        $this->attach_taxonomy();
        $this->create_and_attach_image();
        $this->put_image_in_folder();
    }

    private function get_result_objects()
    {
        foreach ($this->results as $key => $result_id)
        {
            $post = (array) get_post($result_id);
            $meta = (array) get_post_meta($result_id);
            $post = array_merge($post, $meta);

            $this->results[$key] = $post;
        }
    }

    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                                Create                                   │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘

    private function create_post()
    {
        $this->set_default_post_type();
        $this->post->set_args($this->post_value['post']);
        $this->post->add();
        $this->results['post'] = $this->post->result();
    }


    private function create_and_attach_image()
    {
        if (!$this->is_there_an_image()){ return; }
        $this->image->set_args($this->post_value['image']);
        $this->image->set_postid($this->results['post']);
        $this->image->add();
        $this->results['image'] = $this->image->result();
    }


    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                                  Attach                                 │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘


    private function attach_meta()
    {
        if (!isset($this->post_value['meta'])){ return; }
        
        $this->attach->meta_to_post($this->post_value['meta'], $this->results['post']);
    }


    private function attach_taxonomy()
    {
        $this->set_default_tax_term();
        $this->attach->tax_to_post(
            $this->options['ue_save_taxonomy'], 
            $this->options['ue_save_taxonomy_term'], 
            $this->results['post']
        );
        return;
    }


    private function put_image_in_folder()
    {
        if (!$this->is_there_an_image()){ return; }
        $this->realmedia->move_into_RML_folder($this->results['image'], 'genimage');
    }



    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                                Set Defaults                             │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘


    private function set_default_post_type()
    {
        $this->post_value['post']['post_type'] = $this->options['ue_save_posttype'];
    }



    private function set_default_tax_term()
    {
        if ($this->options['ue_save_taxonomy_term'] == "")
        {
            $this->options['ue_save_taxonomy_term'] = "exporting";
        }
    }



    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                                    Checks                               │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘

    private function is_there_an_image()
    {
        if (!isset($this->post_value['image']['path'])) 
        {
            return false;
        }

        if ($this->post_value['image']['path'] == "")
        {
            return false;
        }
        
        return true;
    }


    private function is_disabled()
    {
        if ($this->options['ue_save_group']['ue_save_enabled'] == false)
        {
            return true;
        }
        return false;
    }

}