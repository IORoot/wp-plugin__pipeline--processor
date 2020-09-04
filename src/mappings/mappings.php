<?php

namespace ue;

class mappings
{
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

    /**
     * Single mapping instance
     *
     * @var int
     */
    private $map_value;
    private $map_key;

    /**
     * Single instance of the previous 'process' stage.
     * 
     * [
     *      'title'      => "Tour of toulouse ?? - PARKOUR POV",
     *      'image_grid' => "2020/08/WJOmleWEwYs.jpg",
     *      'content'    => "The content is here",
     * ]
     *
     * @var array
     */
    private $process_value;
    private $process_key;




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
        $this->loop_all_process_objects();
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


    private function loop_all_process_objects()
    {
        foreach ($this->collection['ue\process'] as $this->process_key => $this->process_value)
        {
            $this->process_all_mappings();
        }
    }


    private function process_all_mappings()
    {
        foreach($this->options['ue_save_mapping'] as $this->map_key => $this->map_value)
        {
            $this->swap_dates();
            $this->swap_fields();
            $this->process_mapping();
        }   
    }


    private function swap_dates()
    {
        preg_match_all("/{{date:([\w|\s]+)}}/", $this->map_value['ue_save_mapping_template'], $matches);

        foreach ($matches[1] as $key => $match) {

            $key = $this->process_key;
            $replace_value = date($match);
            $match = '{{date:'.$match.'}}';
            $this->map_value['ue_save_mapping_template'] = str_replace($match, $replace_value, $this->map_value['ue_save_mapping_template']);
        }

    }


    private function swap_fields()
    {
        preg_match_all("/{{([\w|\d|_|:]+)}}/", $this->map_value['ue_save_mapping_template'], $matches);

        foreach ($matches[1] as $match)
        {
            $key = $this->process_key;
            $replace_value = $this->collection['ue\process'][$key][$match];
            $match = '{{'.$match.'}}';
            $this->map_value['ue_save_mapping_template'] = str_replace($match, $replace_value, $this->map_value['ue_save_mapping_template']);
        }
    }



    private function process_mapping()
    {
        $template           = $this->map_value['ue_save_mapping_template'];
        $destination_type   = $this->map_value['ue_save_mapping_group']['ue_save_mapping_destination'];
        $destination_field  = $this->map_value['ue_save_mapping_group']['ue_save_mapping_field'];

        $this->results[$this->process_key][$destination_type][$destination_field] = $template;
    }


}