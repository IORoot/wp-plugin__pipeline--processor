<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class single_image implements mutationInterface
{
    
    public $description = "Overrides with a single image.";

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
