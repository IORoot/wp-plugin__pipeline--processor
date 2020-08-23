<?php

namespace ue\combine;

use ue\interfaces\combineInterface;

class append implements combineInterface
{
    
    use \ue\utils;

    public $description = "Returns first record";

    public $parameters = 'None';

    public $config;

    public $input;

    public $output;
    
    public function config($config)
    {
        $this->config = $config;
        return;
    }

    public function in($input)
    {
        $this->input = $input;
        return;
    }

    public function out()
    {
        $this->process();
        return $this->output;
    }

    public function process()
    {

        $result = $this::array_flat($this->input);
        $this->output = $this::array_regex_keys('/^\d+_'.$this->config.'/', $result);
        
    }

}
