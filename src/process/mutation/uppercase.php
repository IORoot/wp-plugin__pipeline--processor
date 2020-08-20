<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class uppercase implements mutationInterface
{
    
    public $description = "Changes string to UPPERCASE.";

    public $parameters = 'None';

    public $input;
    
    public function config($config)
    {
        return;
    }

    public function in($input)
    {
        $this->input = $input;
        return;
    }

    public function out()
    {
        return strtoupper($this->input);
    }

}
