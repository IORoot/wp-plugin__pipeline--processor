<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class none implements mutationInterface
{
    
    public $description = "";

    public $parameters = '';

    public $input;

    public $config;
    
    public function config($config)
    {
        return;
    }

    public function in($input)
    {
        $this->input = $input;
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
