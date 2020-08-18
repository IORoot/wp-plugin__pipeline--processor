<?php

namespace ue;

use \ue\options;

class exporter
{
    
    public $options;

    public function __construct()
    {
        set_time_limit(600); // 10 mins - apache Timeout = 300 (5 mins)

        $this->options = (new options)->get_options();

        return;
    }


    public function run()
    {
        return;
    }

}