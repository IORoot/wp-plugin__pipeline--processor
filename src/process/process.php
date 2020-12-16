<?php

namespace ue;

class process
{

    use utils;
    use debug;

    public $options;

    public $collection;

    public $results;


    public function set_options($options)
    {
        $this->options = $options['ue_job_process_id'];
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }


    public function run()
    {
        if ($this::is_disabled($this->options, 'process')){ return; }
        $this->process_collection();
        $this->update_combine_selects();
        $this->debug_update('process', $this->results);
        return $this->results;
    }



    private function process_collection()
    {
        $collection = new process_collection;
        $collection->set_config( $this->options['ue_process_collection'] );
        $collection->set_collection( $this->collection['ue\\content'] );
        $this->results = $collection->run();
    }



    /**
     * This updates the ACF dropdowns on the 'combine'
     * tab to contain all fields that are referenced
     * in this 'process' tab. 
     * Basically, if you add a field to process, it 
     * will be added in the 'combine' input field
     * dropdown.
     */
    private function update_combine_selects()
    {

        // Get all choices
        $all_choices = array();
        foreach($this->results as $key => $choices)
        {
            $choice_keys = array_keys($choices);
            $all_choices = array_merge($all_choices, array_keys($choices));
        }
        // Make unique. Not repeats.
        $all_choices = array_unique($all_choices);

        $choice_array = array();
        foreach($all_choices as $key => $value)
        {
            $choice_array[$value] = $value; 
        }



        /**
         * Uses \src\acf\acf_update_options_field.php
         */
        $field = new \update_acf_options_field;
        $field->set_field('ue_combine_input_select');
        $field->set_value('choices', $choice_array);
        $field->run();
    }

}
