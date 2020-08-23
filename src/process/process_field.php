<?php

namespace ue;


class process_field
{
    public $config;

    public $field_key;
    public $field_value;

    public $result;

    public $mutation_group;
    public $mutation_single;


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
        $this->match_mutation_group();

        return $this->result;
    }


    private function match_mutation_group()
    {

        foreach ($this->config as $this->mutation_group)
        {
            if ($this->mutation_group['ue_mutation_input'] != $this->field_key)
            {
                continue;
            }

            $this->loop_through_matched_group();
        }
    }


    private function loop_through_matched_group()
    {
        foreach ($this->mutation_group['ue_mutation_group'] as $this->mutation_single)
        {
            $this->run_mutation();
        }
    }



    private function run_mutation()
    {

        if (!is_string($this->field_value))
        {
            $this->result = $this->field_value;
            return;
        }

        $mut = 'ue_mutation_';
        $mutation_name = '\ue\mutation\\' . $this->mutation_single[$mut.'type'];
        $mutation_args = $this->mutation_single[$mut.'parameters'];
        $mutation_data = $this->field_value;

        $mutation = new $mutation_name;
        $mutation->config($mutation_args);
        $mutation->in($mutation_data);

        $this->result = $mutation->out();

    }


    
}