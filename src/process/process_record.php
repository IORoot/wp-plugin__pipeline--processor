<?php

namespace ue;


class process_records
{

    public $namespace = 'ue';

    public $step_type = 'mutation';

    public $prefix = 'ue_mutation_';

    public $config;

    public $data;

    public $results;

    public $field_to_mutate;

    public $field_name;

    public $mutation_group;

    public $record;

    public function set_config($config)
    {
        $this->config = $config;
    }

    public function set_data($data)
    {
        $this->data = $data;
    }



    public function run()
    {
        $this->results = $this->data;
        $this->loop_through_each_field_to_mutate();
        $this->build_result_array();
        return $this->results;
    }




    public function loop_through_each_field_to_mutate()
    {

        foreach ($this->config as $this->field_to_mutate)
        {
            $this->field_name = $this->field_to_mutate[$this->prefix.'input'];
            $this->loop_through_mutation_group();
        }

    }


    public function loop_through_mutation_group()
    {
        foreach ($this->field_to_mutate[$this->prefix .'group'] as $this->mutation_group)
        {
            $mutation = '\\' . $this->namespace . '\\' . $this->step_type . '\\' . $this->mutation_group[$this->prefix.'type'];
            $config['params']  = $this->mutation_group[$this->prefix.'parameters'];
            $config['field'] = $this->field_name;
            $data  = $this->results;

            $this->results = $this::run_mutation($mutation, $config, $field, $data);
        }
    }


    public static function run_mutation($mutation, $config, $field, $data)
    {
        $mutation = new $mutation;

        $mutation->config($config);
        $mutation->in($data);

        return $mutation->out();
    }


    public function build_result_array()
    {
        
        foreach($this->results as $record_key => $record_value)
        {
            foreach ($record_value as $field_key => $field_value)
            {
                foreach ($this->config as $mutation)
                {
                    if ($field_key == $mutation[$this->prefix.'input'])
                    {
                        $new_array[$record_key][$mutation[$this->prefix.'moustache']] = $field_value;
                    }
                }
            }
        }

        $this->results = $new_array;
    }


}
