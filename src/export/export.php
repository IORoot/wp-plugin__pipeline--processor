<?php

namespace ue;

class export
{

    use debug;
    
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
        $this->options = $options['ue_job_export_id'];
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }

    public function run()
    {
        if ($this->is_disabled()){ return; }
        $this->debug_clear('export');
        $this->loop_through_exporters();
        return $this->results;
    }

    //  ┌─────────────────────────────────────────────────────────────────────────┐
    //  │                                                                         │░
    //  │                                                                         │░
    //  │                                 PRIVATE                                 │░
    //  │                                                                         │░
    //  │                                                                         │░
    //  └─────────────────────────────────────────────────────────────────────────┘░
    //   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░


    private function loop_through_exporters()
    {
        foreach($this->options['ue_export_target_mapping'] as $this->current_exporter)
        {
            $this->run_exporter();
        }
    }


    private function run_exporter()
    {
        $exporterName = $this->current_exporter['acf_fc_layout'];
        $exporterClass = 'ue_'.$exporterName;

        $exporter = new $exporterClass;
        $exporter->set_options($this->current_exporter);
        $exporter->set_data($this->collection['ue\save']);
        $this->results = $exporter->run();
    }


    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │░
    // │                                                                         │░
    // │                                 CHECKS                                  │░
    // │                                                                         │░
    // │                                                                         │░
    // └─────────────────────────────────────────────────────────────────────────┘░
    //  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░


    private function is_disabled()
    {
        if ($this->options['ue_export_group']['ue_export_enabled'] == false)
        {
            return true;
        }
        return false;
    }

}