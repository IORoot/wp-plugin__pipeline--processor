<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class single_image implements mutationInterface
{
    
    public $description = "Allows you to rewrite the contents of a field with the URL of a specified image. Helpful if you want to pass through a consistent image like a watermark.";

    public $parameters = 'None';

    public $input;

    public $config;
    
    public function config($config)
    {
        $this->config = $config;
        return;
    }

    public function in($input)
    {
        $this->input = str_replace(WP_HOME . '/', ABSPATH, $this->config['image']['url']);
    }

    public function out()
    {
        return $this->input;
    }

    public function out_collection()
    {
        return $this->out();
    }
}
