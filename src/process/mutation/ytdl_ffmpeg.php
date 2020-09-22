<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class ytdl_ffmpeg implements mutationInterface
{
    
    use \ue\utils;

    public $description =   "Uses the andyp_youtube_downloader plugin." .PHP_EOL .
                            "This is a PARTIAL youtube video downloader. " . PHP_EOL.
                            "Must have FFMPEG installed on system to run" . PHP_EOL.
                            "Requires a youtube video code, a starttime and duration." . PHP_EOL.
                            "Downloaded videos are put in the /uploads directory." . PHP_EOL;

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
        $this->get_filter_args();
        $this->run_filter();

        return $this->filter_result;
    }

    public function out_collection()
    {
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

}
