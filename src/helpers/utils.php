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
    
    /**
     * Convert array / string to UTF string.
     */
    use utils\to_utf8_string;

    /**
     * Convert array / string / object to a nice JSON format (for outputting to screen)
     */
    use utils\to_pretty_JSON;

    /**
     * Return true / false if section is disabled or not.
     */
    use utils\is_disabled;

    
}