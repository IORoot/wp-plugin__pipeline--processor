<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class none implements mutationInterface
{
    
    public $description = "Does nothing.";

    public $parameters = 'None';

    public $input;

    public $config;
    
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
        return $this->input;
    }


}
