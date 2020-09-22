<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class generator_image implements mutationInterface
{
    
    public $description = "Runs the Generator-Image Plugin to generate and convert files. Requires three settings:
filter_slug  :  The Name of the filter group in genimage you wish to run.
images_array :  An array of WP_Posts or a casted array of WP_Post. The Image generator will look for the post['id']
                field to convert to a real WP_Post object if the WP_Post/WP_Term is not found. see the src/wp/wp_get_image.php
                in the generative images plugin.
saves_array  :  An array of formats you wish to save as.
    ";

    public $parameters = "
    [
        'filter_slug'  => 'corner_dots',
        'saves_array'  => [ 'jpg', 'png', 'svg' ]
        'images_array' => '{{collection}}',
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
        if ($this->is_disabled()){ return; }
        $this->set_filter_slug();
        $this->set_images_array();
        $this->set_saveas_array();
        $this->set_dimensions();
        $this->run_filter();

        return $this->filter_result;
    }

    public function out_collection()
    {
        return $this->out();
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

        // foreach ($this->config['images_array'] as $key => $record)
        // {
        //     $image_group[$key] = $record['_wp_attachment_src'];
        // }

        $this->filter_args[1] = $this->config['images_array'];
        
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
        if (!isset($this->config['save_as'])) {
            return;
        }

        foreach($this->config['save_as'] as $savetype)
        {
            $save_array[$savetype] = true;
        }

        $this->filter_args[2] = $save_array;
    }



    /**
     * set_dimensions function
     *
     * [
     *      width = '600',
     *      height = '600',
     * ]
     * @return void
     */
    private function set_dimensions()
    {
        if ($this->config['image_width'] != '') {
            $resize['width'] = $this->config['image_width'];
        }
        if ($this->config['image_height']  != '') {
            $resize['height'] = $this->config['image_height'];
        }
        if ($this->config['image_width']  != '' || $this->config['image_height']  != '') {
            $this->filter_args[3] = $resize;
        }
    }


    private function run_filter()
    {
        if ($this->filter_args[0] == null || $this->filter_args[1] == null || $this->filter_args[2] == null)
        {
            return;
        }

        $this->filter_result = apply_filters_ref_array('genimage_get_instance', $this->filter_args);
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
