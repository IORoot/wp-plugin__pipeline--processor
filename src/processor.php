<?php

namespace ue;

use \ue\options;
use \ue\content;

class processor
{
    
    public $options;

    public $current_option;

    public $results;

    public $_export_key;

    public $job_id;


    public function __construct()
    {
        set_time_limit(600); // 10 mins - apache Timeout = 300 (5 mins)
    }


    public function set_options($options)
    {
        $this->options = $options;
    }


    public function set_job_id($job_id)
    {
        $this->job_id = $job_id;
    }

    /**
     * run function
     * 
     * Will run all 'enabled' jobs
     *
     * @return void
     */
    public function run()
    {
        if ($this->is_save_only()){ return; }

        foreach ($this->options as $this->_export_key => $current_export) {

            if (!is_int($this->_export_key)){ continue; }
            if ($this->options[$this->_export_key]['ue_job_group']['ue_job_enabled'] != true) { continue; }

            $this->process_single_export();
        }

        return $this->results;
    }

    /**
     * run_single_job function
     * 
     * Run a single job.
     *
     * @return void
     */
    public function run_single_job()
    {
        if (empty($this->job_id)){ return; }

        foreach ($this->options as $this->_export_key => $current_export) {

            if (!is_int($this->_export_key)){ continue; }
            if ($this->options[$this->_export_key]['ue_job_group']['ue_job_id'] != $this->job_id) { continue; }

            $this->process_single_export();
        }

        return $this->results;
    }



    private function process_single_export()
    {
        $this->run_class('ue\content');

        $this->run_class('ue\process'); 

        $this->run_class('ue\combine'); 

        $this->run_class('ue\mappings');

        $this->run_class('ue\save');

        $this->run_class('ue\housekeep');

        $this->run_scheduler();
    }



    private function run_class($classname)
    {
        $class = new $classname;
        $this->conform_options($classname);
        $class->set_options($this->current_option);
        $class->set_collection($this->results);
        $this->results[$classname] = $class->run();
    }


    private function is_save_only()
    {
        return $this->options['saveonly'];
    }


    private function conform_options($classname)
    {
        /**
         * Housekeep expects a certain format for input.
         */
        if ($classname == 'ue\housekeep'){
            unset($this->current_option);
            $current_option = $this->options[$this->_export_key]['ue_job_housekeep_id'];

            $this->current_option['enabled'] = $current_option['ue_housekeep_group']['ue_housekeep_enabled'];
            $this->current_option['action'] = $current_option['ue_housekeep_action'];
            $this->current_option['query'] = $current_option['ue_housekeep_query'];
            return;
        }

        $this->current_option = $this->options[$this->_export_key];
    }


    /**
     * run_scheduler function
     * 
     * Loops through all scheduled starttimes
     *
     * @return void
     */
    private function run_scheduler()
    {   
        
        $current_option = $this->options[$this->_export_key]['ue_job_schedule_id'];

        /**
         * Loop through each schedule
         */
        foreach($current_option['ue_schedule_list'] as $event)
        {
            $this->current_option = [
                'enabled' => $current_option['ue_schedule_group']['ue_schedule_enabled'],
                'hook'    => 'pipeline_processor',
                'params'  => [ 'job_id' => $this->options[$this->_export_key]['ue_job_group']['ue_job_id'] ],    
                'repeats' => $event['schedule']['ue_schedule_repeats'],
                'starts'  => $event['ue_schedule_starts'], 
            ];

            $classname = 'ue\\scheduler';
            $scheduler = new $classname;
            $scheduler->set_options($this->current_option);
            $scheduler->run();
            $this->results[$classname][] = $scheduler->get_event();
        }

    }

}