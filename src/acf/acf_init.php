<?php

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                         Include ACF Options Page                        │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/acf_admin_page.php';
require __DIR__.'/acf_admin_css.php';
require __DIR__.'/acf_fields.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │               Only run when the UPDATE button is clicked                │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/on_update.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │            Populate all of the 'select' types automatically             │
//  └─────────────────────────────────────────────────────────────────────────┘

// jobs
require __DIR__.'/selects/populate_ue_job_auth.php';
require __DIR__.'/selects/populate_ue_job_content.php';
require __DIR__.'/selects/populate_ue_job_export.php';
require __DIR__.'/selects/populate_ue_job_housekeep.php';
require __DIR__.'/selects/populate_ue_job_process.php';
require __DIR__.'/selects/populate_ue_job_combine.php';
require __DIR__.'/selects/populate_ue_job_mapping.php';
require __DIR__.'/selects/populate_ue_job_save.php';
require __DIR__.'/selects/populate_ue_job_schedule.php';

// process
require __DIR__.'/selects/populate_ue_process_filter_slugs.php';
require __DIR__.'/selects/populate_ue_process_input_field.php';
require __DIR__.'/selects/populate_ue_mutation_type.php';
require __DIR__.'/selects/populate_ue_mutation_catalog.php';

// combine
// require __DIR__.'/selects/populate_ue_combine_input_field.php';

// save
require __DIR__.'/selects/populate_ue_save_post_type.php';
require __DIR__.'/selects/populate_ue_save_taxonomy_type.php';

// Schedule
require __DIR__.'/selects/populate_ue_schedule_repeat.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                        ACF Options Update                               │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/acf_update_options_field.php';
