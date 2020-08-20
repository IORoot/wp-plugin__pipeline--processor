<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class none implements mutationInterface
{
    
    public $description = "Does nothing.";

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
        return $this->input;
    }

}
