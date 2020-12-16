<?php

namespace ue;

class combine
{

    use utils;
    use debug;

    public $namespace = 'ue';

    public $step_type = 'combine';

    public $options;

    public $collection;

    public $results;


    public function set_options($options)
    {
        $this->options = $options['ue_job_combine_id'];
    }

    public function set_collection($collection)
    {
        $this->collection = $collection;
    }


    public function run()
    {

        if ($this::is_disabled($this->options, $this->step_type)){ return; }
        $this->process_combine();
        $this->update_mapping_moustaches();
        $this->debug('combine', $this->results);
        return $this->results;
    }



    public function process_combine()
    {
        if ($this->options['ue_process_combine'] != 'combine')
        {
            $this->results = $this->collection['ue\process'];
            return;
        }

        $combine = new process_combine;
        $combine->set_config( $this->options['ue_combine_collection'] );
        $combine->set_data( $this->collection['ue\process'] );
        $this->results = $combine->run();
    }

    /**
     * update_mapping_selects function
     * 
     * Updates all of the {{moustaches}}
     *
     * @return void
     */
    private function update_mapping_moustaches()
    {
        $all_keys = array_keys($this->results[0]);
        $all_keys = implode('}}</div> <div class="ue__moustache">{{',$all_keys);
        $keys = '<div class="ue__moustache">{{'.$all_keys.'}}</div>';

        $field = new \update_acf_options_field;
        $field->set_field('field_5f72dc1d20da8');
        $field->set_value('message', $keys);
        $field->run();
    }

}
