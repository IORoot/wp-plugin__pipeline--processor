<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class uppercase implements mutationInterface
{
    
    public $description = "Changes string to UPPERCASE.";

    public $parameters = 'None';

    public $config;

    public $input;

    private $record_key;
    private $record_value;
    

    public function config($config)
    {
        $this->config = $config;
        return $this->input;;
    }

    public function in($input)
    {
        $this->input = $input;
    }

    public function out()
    {
        $this->process_records();
        return $this->input;
    }


    private function process_records()
    {
        foreach ($this->input as $this->record_key => $this->record_value)
        {
            $this->process_field();
        }
    }

    private function process_field()
    {
        foreach($this->record_value as $field_key => $field_value)
        {
            if ($field_key == $this->config['field'])
            {
                $this->input[$this->record_key][$field_key] = strtoupper($field_value);
            }
        }
    }

}
