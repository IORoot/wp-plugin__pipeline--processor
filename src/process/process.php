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

    public $_key;
    public $_record;

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

        if ($this::is_disabled($this->options, $this->step_type)){ return; }
        
        $this->process_collection();
        $this->debug_update('process', $this->results);

        return $this->results;
    }



    public function process_collection()
    {

        foreach ($this->collection[$this->namespace . '\\' . $this->data_source] as $this->_key => $this->_record)
        {
            $this->results[$this->_key] = $this->process_record();
            $this->debug('process', $this->_record);
        }

    }


    public function process_record()
    {
        $group = $this->namespace . '_job_' . $this->step_type . '_id';
        $dataname = $this->namespace . '_' . $this->step_type . '_collection';
        $config = $this->options[$group][$dataname];

        $record = new process_record;
        $record->set_config( $config );
        $record->set_record($this->_record);
        return $record->run();
    }


}
