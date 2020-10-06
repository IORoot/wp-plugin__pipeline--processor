<?php

/**
 * On save of options page, run.
 */
function save_ue_options()
{
    $screen = get_current_screen();

    if ($screen->id != "pipeline_page_processor") {
        return;
    }
        
    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                           Kick off the program                          │
    // └─────────────────────────────────────────────────────────────────────────┘
    $ue = new \ue\processor;
    $options = (new \ue\options)->get_options();
    $ue->set_options($options);
    $ue->run();
    
    return;
}

// MUST be in a hook
add_action('acf/save_post', 'save_ue_options', 20);