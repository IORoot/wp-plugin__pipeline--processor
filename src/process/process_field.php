<?php

namespace ue;


class process_field
{

    use utils;

    public $config;

    public $record;
    public $collection;
    public $previous_results;

    public $field_key;
    public $field_value;

    public $result;

    public $mutation_group;
    public $mutation_single;


    public function set_config($config)
    {
        $this->config = $config;
    }

    public function set_record($record)
    {
        $this->record = $record;
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }

    public function set_previous_results($previous_results)
    {
        $this->previous_results = $previous_results;
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
            if ($this->mutation_group['ue_mutation_input_select'] != $this->field_key)
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
        foreach ($this->mutation_group['ue_mutation_stack_mutation_stack'] as $this->mutation_single)
        {
            $this->replace_moustaches();
            $this->args_to_array();
            $this->add_extras_to_config();
            $this->run_processing_type();
        }
    }

    /**
     * check_processing_type
     * 
     * Should we run normally through all of the records
     * or do it only once on entire collection?
     * 
     * Collection only works on mutations setup for it.
     * - ffmpeg youtube downloader
     * - ffmpeg multi processor
     *
     * @return void
     */
    private function run_processing_type()
    {
        if ($this->mutation_group['ue_process_method'] == 'collection')
        {
            $this->run_mutation_collection();
            return;
        }

        $this->run_mutation();
    }

    /**
     * args_to_array
     *
     * Converts a string to an array.
     * Useful for converting the input values in the arguments
     * textarea fields into proper arrays.
     * 
     * @return void
     */
    private function args_to_array()
    {
        if(!isset($this->mutation_single['filter_arguments'])){ return; }
        if(is_array($this->mutation_single['filter_arguments'])){ return; }

        $arguments = $this->mutation_single['filter_arguments'];
        $this->mutation_single['filter_arguments'] = $this::string_to_array($arguments);
    }


    /**
     * replace_moustaches
     * 
     * Look for any {{moustache}} brackets
     * and swap them for the $this->moustache value.
     *
     * @return void
     */
    private function replace_moustaches()
    {
        if (!isset($this->mutation_single['acf_fc_layout'])){ return; }
        if ($this->mutation_single['enabled'] == false){ return; }

        foreach($this->mutation_single as $arg_key => $args)
        {
            preg_match_all("/{{([\w|\d|_|:]+)}}/", $args, $matches);

            foreach ($matches[1] as $match_key => $match) 
            {
                $value = '{{'.$match.'}}';
                $replace_with = $this->$match;

                if (is_string($replace_with))
                {
                    $this->mutation_single[$arg_key] = str_replace($value, $replace_with, $this->mutation_single[$arg_key]);
                }

                if (is_array($replace_with))
                {
                    $this->mutation_single[$arg_key] = $replace_with;
                }
            }

            unset($matches);
        }
    }
    

    /**
     * add_extras_to_config
     * 
     * Include all the other bits and pieces incase the
     * mutation needs it.
     *
     * @return void
     */
    private function add_extras_to_config()
    {
        $this->mutation_single['record'] = $this->record;
        $this->mutation_single['collection'] = $this->collection;
        $this->mutation_single['previous_results'] = $this->previous_results;
        $this->mutation_single['field_key'] = $this->field_key;
        $this->mutation_single['field_value'] = $this->field_value;
    }

    /**
     * run_mutation
     * 
     * Find the mutation selected and run it.
     *
     * @return void
     */
    private function run_mutation()
    {

        $mutation_name = '\ue\mutation\\' . $this->mutation_single['acf_fc_layout'];
        $mutation = new $mutation_name;
        $mutation->config($this->mutation_single);
        $mutation->in($this->field_value);

        $this->result = $mutation->out();

    }

    /**
     * run_mutation_collection
     * 
     * Only run once on the first record, but do the entire
     * collection at the same time. (Only if mutation can do it).
     *
     * @return void
     */
    private function run_mutation_collection()
    {
        // Is this the first record in the collection?
        if ($this->record['ID'] != $this->collection[0]['ID'])
        {
            $this->result = null;
            return;
        }

        $mutation_name = '\ue\mutation\\' . $this->mutation_single['acf_fc_layout'];
        $mutation = new $mutation_name;
        $mutation->config($this->mutation_single);
        $mutation->in($this->field_value);

        // Alternative method to run entire collection.
        $this->result = $mutation->out_collection();

    }
    
}