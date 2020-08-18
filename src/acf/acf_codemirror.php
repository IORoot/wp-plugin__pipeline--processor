<?php

function ue_codemirror_enqueue_scripts($hook)
{

    $codemirror_settings = array(
        'type' => 'text/css',
        'codemirror' => [
            'theme' => 'material-darker',
        ],    
    );

    wp_enqueue_script('wp-theme-plugin-editor');
    wp_enqueue_style('wp-codemirror');

    $cm_settings['codeEditor'] = wp_enqueue_code_editor($codemirror_settings);
    wp_localize_script('wp-theme-plugin-editor', 'cm_settings', $cm_settings);

}

add_action('admin_enqueue_scripts', 'ue_codemirror_enqueue_scripts');



function ue_codemirror_js()
{
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            $('.ue__codemirror textarea').each( function( index ) {
                wp.codeEditor.initialize(
                    this, cm_settings
                );
            });

        })
    </script>
    <?php
}
    

add_action('acf/input/admin_footer', 'ue_codemirror_js');


function ue_codemirror_css()
{
    ?>
    <style type="text/css">
        <?php include 'css/material.css'; ?>
    </style>
    <?php
}

add_action('acf/input/admin_head', 'ue_codemirror_css');
