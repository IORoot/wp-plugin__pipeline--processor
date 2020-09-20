<?php

namespace ue\combine;

use ue\interfaces\combineInterface;

class all implements combineInterface
{

    use \ue\utils;

    public $description = "Keep all array extries.";

    public $parameters = 'None';
    
    public $config;

    public $input;

    public $output;
    
    public function config($config)
    {
        $this->config = $config;
    }

    public function in($input)
    {
        $this->input = $input;
    }

    public function out()
    {
        $this->process();
        return $this->output;
    }

    public function process()
    {        
        $this->output = $this::array_flat($this->input);
    }

}
