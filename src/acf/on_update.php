<?php

/**
 * On save of options page, run.
 */
function save_ue_options()
{
    $screen = get_current_screen();

    if ($screen->id != "andyp_page_universalexporter") {
        return;
    }
        
    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                           Kick off the program                          │
    // └─────────────────────────────────────────────────────────────────────────┘
    $ue = new \ue\exporter;
    $ue->run();
    
    return;
}

// MUST be in a hook
add_action('acf/save_post', 'save_ue_options', 20);