<?php

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                         Include ACF Options Page                        │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/acf_admin_page.php';
require __DIR__.'/acf_codemirror.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │               Only run when the UPDATE button is clicked                │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/on_update.php';


//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │            Populate all of the 'select' types automatically             │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/populate_ue_job_auth.php';
require __DIR__.'/populate_ue_job_content.php';
require __DIR__.'/populate_ue_job_export.php';
require __DIR__.'/populate_ue_job_housekeep.php';
require __DIR__.'/populate_ue_job_process.php';
require __DIR__.'/populate_ue_job_save.php';
require __DIR__.'/populate_ue_job_schedule.php';