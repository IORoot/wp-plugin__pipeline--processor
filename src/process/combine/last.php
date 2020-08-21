<?php

namespace ue\combine;

use ue\interfaces\combineInterface;

class last implements combineInterface
{
    
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
        
        if (array_key_exists(0,$this->input))
        {
            $last = end($this->input);
            $this->output[$this->config] = $last[$this->config];
            return;
        }
        
        // only one row anyway.
        $this->output[$this->config] = $this->input[$this->config];
    }

}
