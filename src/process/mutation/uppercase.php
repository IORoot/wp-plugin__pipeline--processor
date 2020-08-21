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
        return $this->input;
    }

    public function in($input)
    {
        $this->input = $input;
    }

    public function out()
    {
        $this->loop_through_all_records();
        return $this->input;
    }


    private function loop_through_all_records()
    {
        foreach ($this->input as $this->record_key => $this->record_value)
        {
            $this->loop_through_each_field();
        }
    }



    private function loop_through_each_field()
    {
        $field_i_need = $this->config['field'];
        $array_builder = explode('->', $field_i_need);

        foreach($array_builder as $field_name)
        {

            if (is_string($this->record_value[$field_name]))
            {
                $this->input[$this->record_key][$field_i_need] = strtoupper($this->record_value[$field_name]);
            }

            $this->record_value = $this->record_value[$field_name];
        }
    }


}
