<?php

namespace ue;


class process_collection
{

    use utils;

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
        $this->flatten_data_records();
        return $this->result;
    }



    public function loop_through_all_records()
    {
        foreach ($this->collection as $this->collection_key => $this->collection_record)
        {
            $this->process_record();
        }
    }


    
    public function process_record()
    {
        $record = new process_record;
        $record->set_config($this->config);
        $record->set_record($this->collection_record);       // used for {{record}} moustache
        $record->set_collection($this->collection);          // used for {{collection}} moustache
        $record->set_previous_results($this->result);        // used for {{previous_result}} moustache
        $this->result[$this->collection_key] = $record->run();
    }



    public function flatten_data_records()
    {
        foreach ($this->result as $key => $value)
        {
            $this->result[$key] = $this::array_flat($value);
        }
    }

}
