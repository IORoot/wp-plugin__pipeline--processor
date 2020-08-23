<?php

namespace ue\combine;

use ue\interfaces\combineInterface;

class first implements combineInterface
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

        $result = $this::array_regex_keys('/^'.$this->config.'.*/', $this->input[0]);
        
        if (is_array($result))
        {
            $this->output = $result;
            return;
        }
        $this->output[$this->config] = $result;
    }




}
