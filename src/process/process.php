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
        $this->process_combine();
        $this->debug_update('process', $this->results);
        return $this->results;
    }



    public function process_collection()
    {

        $dataname = $this->namespace . '_' . $this->step_type . '_collection';
        $config = $this->options[$dataname];

        $data = $this->collection[$this->namespace . '\\' . $this->data_source];

        $collection = new process_collection;
        $collection->set_config( $config );
        $collection->set_collection( $data );
        $this->results = $collection->run();
    }





    public function process_combine()
    {
        if ($this->options[$this->namespace . '_' . $this->step_type . '_combine'] != 'combine')
        {
            return;
        }

        $dataname = $this->namespace . '_' . $this->step_type . '_collection';
        $config = $this->options[$dataname];

        $combine = new process_combine;
        $combine->set_config( $config );
        $combine->set_data( $this->results );
        $this->results = $combine->run();
    }

}
