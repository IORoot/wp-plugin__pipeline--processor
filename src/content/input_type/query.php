<?php

namespace ue\content;

class query
{

    use \ue\utils;
    use \ue\wp;

    public $args;

    public function set_args($query)
    {
        $this->args = $this::string_to_array($query);
    }


    public function run()
    {
        $this->result = $this::wp_get_posts_with_meta($this->args);
        return $this->result;
    }

}