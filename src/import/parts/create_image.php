<?php

namespace ue\import;

class image
{

    public $url;

    public $alt = 'Universal Exporter';

    public $filename;

    public $args;

    public $postid;

    public $result_id;


    public function __construct()
    {
        return $this;
    }

    public function set_args($args)
    {
        $this->args = $args;
    }


    public function set_postid($postid)
    {
        $this->postid = $postid;
    }


    public function add()
    {
        $this->add_image();
        return;
    }

    public function result()
    {
        return $this->result_id;
    }


    private function add_image()
    {
        $image = new \ue\wp\set_image;
        $image->set_filename($this->args['path']);
        $image->set_id($this->postid);
        $this->result_id = $image->update_post_thumbnail();
    }


}