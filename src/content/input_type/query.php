<?php

namespace ue\content;

class query
{

    use \ue\utils;
    use \ue\wp;
    use \ue\debug;

    public $args;

    public function set_args($query)
    {
        $this->args = $this::string_to_wpquery($query);
    }


    public function run()
    {
        $result = $this::wp_get_posts_with_meta($this->args);
        $this->debug('content', $result);
        return $result;
    }


}
