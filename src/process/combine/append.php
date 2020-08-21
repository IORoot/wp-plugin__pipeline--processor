<?php

namespace ue\combine;

use ue\interfaces\combineInterface;

class append implements combineInterface
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
        return;
    }

    public function out()
    {
        $this->process();
        return $this->output;
    }

    public function process()
    {
        foreach ($this->input as $record)
        {
            foreach ($record as $field_key => $field_value)
            {
                if ($field_key == $this->config)
                {
                    $this->output[$field_key] .= $field_value . ' ';
                }
            }
        }
    }

}
