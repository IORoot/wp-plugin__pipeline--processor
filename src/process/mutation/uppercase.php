<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class uppercase implements mutationInterface
{
    
    public $description = "";

    public $parameters = '';

    public $config;

    public $input;
    

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
        return strtoupper($this->input);
    }

    public function out_collection()
    {
        return $this->out();
    }
}
