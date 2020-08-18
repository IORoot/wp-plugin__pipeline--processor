<?php

namespace ue;

use \ue\options;
use \ue\content;

class exporter
{
    
    public $options;

    public $results;

    public $_export_key;


    public function __construct()
    {
        set_time_limit(600); // 10 mins - apache Timeout = 300 (5 mins)

        $this->options = (new options)->get_options();

        return;
    }





    public function run()
    {
        // loop over each export instance.
        foreach ($this->options as $this->_export_key => $current_export) {


            // has this export been enabled?
            if ($this->options[$this->_export_key]['ue_job_group']['ue_job_enabled'] != true) {
                continue;
            }

            // run it.
            $this->process_single_export();
        }

        return;
    }





    public function process_single_export()
    {
        $this->run_class('ue\content');
    }



    public function run_class($classname)
    {
        $class = new $classname;
        $class->set_options($this->options[$this->_export_key]);
        $this->results[$classname] = $class->run();
    }



}