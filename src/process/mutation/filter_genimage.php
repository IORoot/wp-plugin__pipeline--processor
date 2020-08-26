<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class filter_genimage implements mutationInterface
{
    
    public $description = "Runs the GENIMAGE Filter to generate and convert files. Requires three settings:
filter_slug  : The Name of the filter group in genimage you wish to run.
images_array : An array of images to process.
saves_array  : An array of formats you wish to save as.
    ";

    public $parameters = "
    [
        'filter_slug'  => 'corner_dots',
        'images_array' => '{{collection}}',
        'saves_array'  => [ 'jpg', 'png', 'svg' ]
    ]
    ";

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
        $this->set_filter_slug();
        $this->set_images_array();
        $this->set_saveas_array();
        $this->run_filter();

        return $this->filter_result;
    }


    /**
     * filter_slug variable
     * 
     * The slug of the filter group you want to process.
     *
     * @var string
     */
    private function set_filter_slug()
    {
        if (!isset($this->config['filter_slug'])) {
            return;
        }

        $this->filter_args[0] = $this->config['filter_slug'];
    }


    /**
     * Contains an array of instances of current images' metadata.
     * 0 => [
     *      0 => Relative directory of image
     *      1 => width
     *      2 => height
     * ]
     *
     * @var array
     */
    private function set_images_array()
    {
        if (!isset($this->config['images_array'])) {
            return;
        }

        foreach ($this->config['images_array'] as $key => $record)
        {
            $image_group[$key] = $record['_wp_attachment_src'];
        }

        // Set the second argument to result.images_array
        $this->filter_args[1] = $image_group;
        
    }

    /**
     * save_types
     * 
     * Array of what to save the file as.
     * 
     * [
     *      svg : true,
     *      png : false,
     *      jpg : true,
     * ]
     *
     * @var array
     */
    private function set_saveas_array()
    {
        if (!isset($this->config['saves_array'])) {
            return;
        }

        foreach($this->config['saves_array'] as $savetype)
        {
            $save_array[$savetype] = true;
        }

        $this->filter_args[2] = $save_array;
    }



    private function run_filter()
    {
        if ($this->filter_args[0] == null || $this->filter_args[1] == null || $this->filter_args[2] == null)
        {
            return;
        }
        
        $this->filter_result = apply_filters_ref_array('genimage_get_svgdata', $this->filter_args);
    }


}
