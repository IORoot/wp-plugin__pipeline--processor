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

            $this->loop_through_matched_stack();
        }
    }


    /**
     * loop_through_matched_stack function
     * 
     * This is the flexible content section.
     * 
     * @return void
     */
    private function loop_through_matched_stack()
    {
        foreach ($this->mutation_group['ue_mutation_stack'] as $this->mutation_single)
        {
            $this->args_to_array();
            $this->replace_moustaches();
            $this->run_mutation();
        }
    }



    private function args_to_array()
    {
        if(!isset($this->mutation_single['filter_arguments'])){ return; }
        $arguments = $this->mutation_single['filter_arguments'];
        $this->mutation_single['filter_arguments'] = $this::string_to_array($arguments);
    }


    private function replace_moustaches()
    {
        if (!isset($this->mutation_single['acf_fc_layout'])){ return; }
        if ($this->mutation_single['enabled'] == false){ return; }

        foreach($this->mutation_single as $arg_key => $args)
        {

            /**
             * ANDYP TODO
             * Needs to be recursive, otherwise nested args are not moustache processed.
             */
            if (is_array($args)){
                return;
            }

            preg_match_all("/{{([\w|\d|_|:]+)}}/", $args, $matches);

            foreach ($matches[1] as $match_key => $match) 
            {
                $this->mutation_single[$arg_key] = $this->$match;
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

        $mutation_name = '\ue\mutation\\' . $this->mutation_single['acf_fc_layout'];
        $mutation = new $mutation_name;
        $mutation->config($this->mutation_single);
        $mutation->in($this->field_value);

        $this->result = $mutation->out();

    }


    
}