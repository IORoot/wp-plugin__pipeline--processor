<?php


function ue_css()
{
    ?>
    <style type="text/css">
        <?php include 'css/admin.css'; ?>
    </style>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css" rel="stylesheet">
    <?php
}

add_action('acf/input/admin_head', 'ue_css');
