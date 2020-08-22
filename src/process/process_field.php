<?php

namespace ue;


class process_field
{
    public $config;

    public $field_key;
    public $field_value;

    public $result;

    public function set_config($config)
    {
        $this->config = $config;
    }

    public function set_field_key($field_key)
    {
        $this->field_key = $field_key;
    }

    public function set_field_value($field_value)
    {
        $this->field_value = $field_value;
    }

    public function run()
    {
        if(!$this->does_field_need_mutation()){ return; }

        $this->mutate_field();

        return $this->result;
    }


    private function mutate_field()
    {
        
        return;
    }



    private function does_field_need_mutation()
    {
        foreach ($this->config as $mutation)
        {
            if ($mutation['ue_mutation_input'] == $this->field_key)
            {
                return true;
            }
        }
        return false;
    }
    
}