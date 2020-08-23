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
        
        $last_element = end($this->input);
        $result = $this::array_regex_keys('/^'.$this->config.'.*/', $last_element);
        
        if (is_array($result))
        {
            $this->output = $result;
            return;
        }
        $this->output[$this->config] = $result;

    }

}
