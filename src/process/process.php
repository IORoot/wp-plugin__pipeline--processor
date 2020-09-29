<?php

namespace ue;

class process
{

    use utils;
    use debug;
    
    public $namespace = 'ue';
    
    public $data_source = 'content';

    public $step_type = 'process';

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
        if ($this::is_disabled($this->options, $this->step_type)){ return; }
        $this->process_collection();
        $this->update_combine_selects();
        $this->debug('process', $this->results);
        return $this->results;
    }



    private function process_collection()
    {

        $dataname = $this->namespace . '_' . $this->step_type . '_collection';
        $config = $this->options[$dataname];

        $data = $this->collection[$this->namespace . '\\' . $this->data_source];

        $collection = new process_collection;
        $collection->set_config( $config );
        $collection->set_collection( $data );
        $this->results = $collection->run();
    }


    private function update_combine_selects()
    {

        // Get all choices
        $all_choices = array();
        foreach($this->results as $key => $choices)
        {
            $all_choices = array_merge($all_choices, array_keys($choices));
        }
        $all_choices = array_unique($all_choices);

        $field = new \update_acf_options_field;
        $field->set_field('field_5f70506e00672');
        $field->set_value('choices', $all_choices);
        $field->run();
    }

}
