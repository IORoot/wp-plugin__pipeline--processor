<?php

namespace ue\content;

class posts
{

    use \ue\utils;
    use \ue\wp;

    public $args;

    public $result;

    public function set_args($query)
    {
        $this->args = $query;
    }


    public function run()
    {
        foreach ($this->args as $key => $post)
        {
            $this->result[$key]['post'] = $post;
            $this->result[$key]['meta'] = $this::wp_get_meta($post->ID);
        }

        return $this->result;
    }

}
