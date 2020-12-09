<?php

namespace ue;

class housekeep
{
    public $options;

    public $result;

    public function __construct()
    {
        return $this;
    }


    public function set_options($options)
    {
        $this->options = $options;
    }

    public function run()
    {
        if ($this->options == 'none') {
            return;
        }
        if (!isset($this->options)) {
            return;
        }
        if ($this->options['yt_housekeep_enabled'] == false) {
            return;
        }

        $this->instantiate_instance();
    }

    public function instantiate_instance()
    {
        $instance_type = '\\ue\\housekeep\\'.$this->options['yt_housekeep_action'];
        $housekeep = new $instance_type;
        $housekeep->wp_query($this->options['yt_housekeep_query']);
        $housekeep->run();
        $housekeep->result();
    }
}
