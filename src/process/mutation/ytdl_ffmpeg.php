<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class ytdl_ffmpeg implements mutationInterface
{
    
    use \ue\utils;

    public $description = "";

    public $parameters = "";

    public $input;

    public $config;
    
    public function config($config) 
    {
        $this->config = $config;
        return;
    }

    public function in($input)
    {
        $this->input = $input;
    }


    public function out()
    {
        if ($this->is_disabled()){ return; }
        
        $this->get_filter_args();
        $this->run_filter();

        return $this->filter_result;
    }


    /**
     * Used to run against multiple records
     */
    public function out_collection()
    {
        if ($this->is_disabled()){ return; }

        foreach ($this->config['collection'] as $this->current_key => $this->current_record)
        {
            $this->get_field();
            $this->get_filter_args();
            $this->run_filter_collection();
        }

        return $this->filter_result;
    }


    private function get_field()
    {
        // get the filename for this record.
        $record_field = explode('->', $this->config['field_key']);
        $this->current_field = $this->current_record;
        foreach ($record_field as $location) {
            $this->current_field = $this->current_field[$location];
        }

        $this->config['youtube_video_code'] = $this->current_field;
    }





    private function get_filter_args()
    {
        $this->filter_args = [
            $this->config['youtube_video_code'],
            $this->config['video_seek_start_point'],
            $this->config['video_seek_duration'],
            '_video',
            $this->config['override'],
        ];
    }



    private function run_filter()
    {
        $this->filter_result = apply_filters_ref_array('ytdl_ffmpeg', $this->filter_args);
    }

    private function run_filter_collection()
    {
        $this->filter_result[] = apply_filters_ref_array('ytdl_ffmpeg', $this->filter_args);
    }

    /**
     * is_disabled function
     *
     * Check to see if enabled or not.
     * 
     * @return boolean
     */
    private function is_disabled()
    {
        if ($this->config['enabled'] == false)
        {
            return true;
        }
        return false;
    }

}
