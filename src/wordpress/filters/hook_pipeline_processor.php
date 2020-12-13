<?php

namespace filter;

class pipeline_processor {


    public function __construct()
    {
        add_filter( 'pipeline_processor', array($this,'run_processor'), 10, 1);
    }

    
    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                           Kick off the program                          │
    // └─────────────────────────────────────────────────────────────────────────┘
    public function run_processor($job_id){

        $ue = new \ue\processor;
        $options = (new \ue\options)->get_options();
        $ue->set_options($options);
        $ue->set_job_id($job_id);
        $results = $ue->run_single_job();

        return $results;
    }
    
}