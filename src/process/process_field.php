<?php

namespace ue;


class process_field
{

    use utils;

    public $config;

    public $record;
    public $collection;

    public $field_key;
    public $field_value;

    public $result;

    public $mutation_group;
    public $mutation_single;


    public function set_config($config)
    {
        $this->config = $config;
    }

    /**
     * set_record
     * 
     * Used for {{record}} moustache
     *
     * @param array $record
     * @return void
     */
    public function set_record($record)
    {
        $this->record = $record;
    }

    /**
     * set_collection
     * 
     * Used for {{collection}} moustache
     *
     * @param array $collection
     * @return void
     */
    public function set_collection($collection)
    {
        $this->collection = $collection;
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
            $this->args_to_array();
            $this->replace_moustaches();
            $this->run_mutation();
        }
    }



    private function args_to_array()
    {
        $config = $this->mutation_single['ue_mutation_parameters'];
        $this->mutation_single['ue_mutation_parameters'] = $this::string_to_array($config);
    }


    private function replace_moustaches()
    {
        foreach($this->mutation_single['ue_mutation_parameters'] as $arg_key => $args)
        {
            preg_match_all("/{{([\w|\d|_|:]+)}}/", $args, $matches);

            foreach ($matches[1] as $match_key => $match) 
            {
                $this->mutation_single['ue_mutation_parameters'][$arg_key] = $this->$match;
            }

            unset($matches);
        }
    }
    

    private function run_mutation()
    {

        if (!is_string($this->field_value))
        {
            $this->result = $this->field_value;
            return;
        }

        $mutation_name = '\ue\mutation\\' . $this->mutation_single['ue_mutation_type'];
        $mutation_args = $this->mutation_single['ue_mutation_parameters'];
        $mutation_data = $this->field_value;

        $mutation = new $mutation_name;
        $mutation->config($mutation_args);
        $mutation->in($mutation_data);

        $this->result = $mutation->out();

    }


    
}