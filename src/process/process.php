<?php

namespace ue;

class process
{

    use utils;   

    public $options;

    public $collection;

    public $results;

    public $class_object;


    public function set_options($options)
    {
        $this->options = $options;
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }


    public function run()
    {

        if ($this->is_disabled()){ return; }
        
        $this->process_mutations();

        return $this->results;
    }



    public function is_disabled()
    {
        if ($this->options['ue_job_process_id']['ue_process_group']['ue_process_enabled'] == false)
        {
            return true;
        }
        return false;
    }




    public function process_mutations()
    {
        $process_groups = $this->options['ue_job_process_id']['ue_process_mutations'];

        foreach ($mutation_groups as $key => $mutation)
        {

        }

        return;

    }



}
