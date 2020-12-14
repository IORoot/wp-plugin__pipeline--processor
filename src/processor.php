<?php

namespace ue;

use \ue\options;
use \ue\content;

class processor
{
    
    public $options;

    public $results;

    public $_export_key;

    public $job_id;
    
    public $running_from_action;


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
        
        $this->running_from_action = true;

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

        if ($this->running_from_action){ return; }

        $this->run_class('ue\schedule');
    }



    private function run_class($classname)
    {
        $class = new $classname;
        $class->set_options($this->options[$this->_export_key]);
        $class->set_collection($this->results);
        $this->results[$classname] = $class->run();
    }


    private function is_save_only()
    {
        return $this->options['saveonly'];
    }

}