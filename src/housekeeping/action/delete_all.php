<?php

namespace ue\housekeep;

use ue\interfaces\housekeepInterface;

class delete_all implements housekeepInterface
{
    public $query;

    public $post_list;

    public $response;


    public function wp_query($wp_query)
    {

        $config = preg_replace("/\r|\n/", "", $wp_query);
        $this->query = @eval("return " . $config . ";");
        $this->post_list();

        return;
    }

    public function run()
    {
        if (empty($this->post_list)) {
            return;
        }
        foreach ($this->post_list as $post) {
            $this->delete_image($post->ID);
            $this->delete_post($post->ID);
        }

        return;
    }

    public function result()
    {
        if (!isset($this->post_list)){ return false; }
        if (empty($this->post_list)){ return false; }
        return true;
    }


    public function post_list()
    {
        if (!is_array($this->query)){
            return;
        }
        $this->post_list = get_posts($this->query);
    }



    public function delete_post($post_id)
    {
        $this->response[] = wp_delete_post($post_id, true);
    }

    
    public function delete_image($post_id)
    {
        $attachment_id = get_post_thumbnail_id($post_id);
        if ($attachment_id != '') {
            $this->response[] = wp_delete_attachment($attachment_id, true);
        }
    }
}
