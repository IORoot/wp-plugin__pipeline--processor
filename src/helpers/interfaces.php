<?php

namespace ue;

class interfaces 
{

    /**
     * List the available interface instances 'mutations', 'transforms', 'filters', etc...
     */
    use interfaces\list_filenames;


    /**
     * List the available interface instances descriptions, parameters and title.
     */
    use interfaces\list_catalog;
    
}