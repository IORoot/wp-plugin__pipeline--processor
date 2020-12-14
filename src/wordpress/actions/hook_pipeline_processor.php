<?php

namespace ue\action;

class pipeline_processor {


    public function __construct()
    {
        add_action( 'pipeline_processor', array($this,'run_processor'), 10, 2);
    }

    
    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                           Kick off the program                          │
    // └─────────────────────────────────────────────────────────────────────────┘

    /**
     * run_processor function
     *
     * The job_id is the ID of the Processor Job you want to run
     * 
     * The label is only used within the cron system to make the schedule
     * entry unique. if you have multiple times to run the job, and they only have
     * the job_id, then they will overwrite each other and use the last one made.
     * With an extra label, this makes each entry unique and allows you to have
     * multiple cron entries for one filter.
     * 
     * @param [string] $job_id
     * @param [string] $label
     * @return void
     */
    public function run_processor($job_id, $label = null){

        $ue = new \ue\processor;
        $options = (new \ue\options)->get_options();
        $ue->set_options($options);
        $ue->set_job_id($job_id);
        $results = $ue->run_single_job();

        return $results;
    }
    
}