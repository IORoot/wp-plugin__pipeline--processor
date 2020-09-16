<?php

// ┌───────────────────────────────────────────────────────────────────────────┐
// │Explanations at:                                                           │
// │                                                                           │
// │- https://dev.to/ioroot/google-oauth-wordpress-youtube-service-api-4ko6    │
// │                                                                           │
// │- https://ioroot.com/wordpress-oauth-and-ajax/                             │
// │                                                                           │
// │- https://github.com/IORoot/wp-plugin__oauth-demo                          │
// │                                                                           │
// └───────────────────────────────────────────────────────────────────────────┘

/**
 * Load the Javascript into the Admin page footer.
 */
require __DIR__.'/actions/enqueue_js.php';

/**
 * Create the AJAX callback action for the redirect
 * back to the app.
 */
require __DIR__.'/actions/oauth_callback.php';