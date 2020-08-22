<?php

namespace ue;


class process_collection
{

    public $config;

    public $collection;
    public $collection_key;
    public $collection_record;

    public $result;

    public function set_config($config)
    {
        $this->config = $config;
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }

    public function run()
    {
        $this->loop_through_all_records();
        return $this->results;
    }

    //  ┌─────────────────────────────────────────────────────────────────────────┐
    //  │                                                                         │░
    //  │                                                                         │░
    //  │                         Loop through each record                        │░
    //  │                                                                         │░
    //  │                                                                         │░
    //  └─────────────────────────────────────────────────────────────────────────┘░
    //   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░

    public function loop_through_all_records()
    {

        foreach ($this->collection as $this->collection_key => $this->collection_record)
        {
            $this->collection_record = $this->process_record();
        }

    }

    
    public function process_record()
    {
        $record = new process_record;
        $record->set_config($this->config);
        $record->set_record($this->collection_record);
        return $record->run();
    }

}
