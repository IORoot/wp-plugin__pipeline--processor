<?php

namespace ue;

trait utils 
{

    /**
     * Check class exists and instantiate it.
     */
    use utils\class_instantiate;

    /**
     * Check a class exists.
     */
    use utils\class_exists;

    /**
     * Convert a string interpretation of WP_Query into an array.
     */
    use utils\string_to_wpquery;
    
}