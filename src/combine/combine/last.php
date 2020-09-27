<?php

namespace ue\combine;

use ue\interfaces\combineInterface;

class last implements combineInterface
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
        return $this->output;
    }

    public function out()
    {
        $this->process();
        return $this->output;
    }

    public function process()
    {
        
        $count = count($this->input) - 1;

        $value = $this->input[$count][$this->config['ue_combine_input_select']];

        $this->output[$this->config['ue_combine_input_select']] = $value;

    }

}
