<?php

namespace ue;


class process_field
{

    public $namespace = 'ue';

    public $step_type = 'mutation';

    public $prefix = 'ue_mutation_';

    public $config;

    public $data;
    
    public $moustache;

    public $current_mutation_group;
    public $current_mutation;


    public function set_data($data)
    {
        $this->data = $data;
    }


    public function set_config($config)
    {
        $this->config = $config;
    }



    public function run()
    {
        $this->select_mutation_group();
        return $this->data;
    }


    public function select_mutation_group()
    {
        foreach ($this->config as $this->current_mutation_group)
        {
            if ($this->current_mutation_group[$this->prefix.'input'] == $this->data['key'])
            {
                $this->data['key'] = $this->current_mutation_group[$this->prefix.'moustache'];
                $this->run_mutation_group();
            }
        }
    }


    public function run_mutation_group()
    {

        foreach ($this->current_mutation_group[$this->prefix.'group'] as $this->current_mutation)
        {
            $mutation_type  = $this->current_mutation[$this->prefix.'type'];
            $mutation_args  = $this->current_mutation[$this->prefix.'parameters'];
            $mutation_class = '\\' . $this->namespace . '\\' . $this->step_type . '\\' . $mutation_type;

            $mutation = new $mutation_class;
            $mutation->config($mutation_args);
            $mutation->in($this->data['value']);
            $this->data['value'] = $mutation->out();
        }

    }

}
