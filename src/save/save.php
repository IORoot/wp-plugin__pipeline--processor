<?php

namespace ue;

class save
{
    public $options;

    public $collection;

    public $results;

    public function set_options($options)
    {
        $this->options = $options['ue_job_save_id'];
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }

    public function run()
    {
        $this->process_all_mappings();
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


    private function process_all_mappings()
    {
        foreach($this->options['ue_save_mapping'] as $this->map_key => $this->map_value)
        {
            $this->substitute_fields();
            $this->process_mapping();
        }   
    }



    private function substitute_fields()
    {
        preg_match_all("/{{([\w|\d|_|:]+)}}/", $this->map_value['ue_save_mapping_template'], $matches);

        foreach ($matches[1] as $match)
        {
            $replace_value = $this->collection['ue\process'][$match];
            $match = '{{'.$match.'}}';
            $this->map_value['ue_save_mapping_template'] = str_replace($match, $replace_value, $this->map_value['ue_save_mapping_template']);
        }

    }



    private function process_mapping()
    {
        $template           = $this->map_value['ue_save_mapping_template'];
        $destination_type   = $this->map_value['ue_save_mapping_destination'];
        $destination_field  = $this->map_value['ue_save_mapping_field'];

        $this->results[$destination_type][$destination_field] = $template;
    }



}