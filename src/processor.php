<?php

namespace ue;

use \ue\options;
use \ue\content;

class processor
{
    
    public $options;

    public $results;

    public $_export_key;


    public function __construct()
    {
        set_time_limit(600); // 10 mins - apache Timeout = 300 (5 mins)

        return;
    }


    public function set_options($options)
    {
        $this->options = $options;
    }


    public function run()
    {

        if ($this->is_save_only()){ return; }

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





    private function process_single_export()
    {
        $this->run_class('ue\content');

        $this->run_class('ue\process'); 

        $this->run_class('ue\combine'); 

        $this->run_class('ue\mappings');

        $this->run_class('ue\save');

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