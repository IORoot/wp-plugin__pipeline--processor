<?php

namespace ue;

class schedule
{

/**
     * options variable
     * 
     * Contains all of the "save" options for this instance.
     *
     * @var array
     */
    public $options;

    /**
     * collection variable
     * 
     * Contains all the results of each stage of the
     * universal exporter process.
     *
     * @var array
     */
    public $collection;

    /**
     * results variable
     *
     * What will be placed into the $collection
     * array once this stage is complete.
     * 
     * @var array
     */
    public $results;


    public function set_options($options)
    {
        $this->options = $options['ue_job_schedule_id'];
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }

    public function run()
    {
        return $this->results;
    }



}