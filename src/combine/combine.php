<?php

namespace ue;

class combine
{

    use utils;
    use debug;

    public $namespace = 'ue';

    public $step_type = 'combine';

    public $options;

    public $collection;

    public $results;


    public function set_options($options)
    {
        $this->options = $options['ue_job_combine_id'];
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }


    public function run()
    {

        if ($this::is_disabled($this->options, $this->step_type)){ return; }
        $this->process_combine();
        $this->debug('combine', $this->results);
        return $this->results;
    }



    public function process_combine()
    {
        if ($this->options['ue_process_combine'] != 'combine')
        {
            return;
        }

        $combine = new process_combine;
        $combine->set_config( $this->options['ue_combine_collection'] );
        $combine->set_data( $this->collection['ue\process'] );
        $this->results = $combine->run();
    }

}
