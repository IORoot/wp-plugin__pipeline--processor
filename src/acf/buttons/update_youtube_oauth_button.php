<?php

function acf_change_yt_oauth_button_state( $field ) {

    /**
     * Update CSS class if refresh token found.
     */
    if (false !== (get_transient( 'YT_OAUTH_REFRESH_TOKEN' ))) {
        $field['wrapper']['class'] = 'enabled';
        $field['message'] = str_replace('>YouTube OAUTH<', '>Refresh Token Found<', $field['message']);
        return $field;
    }

    /**
     * Default.
     */
    $field['wrapper']['class'] = ""; // remove 'enabled'
    $field['message'] = '<button type="button" class="button-secondary" id="acf__youtube-oauth">YouTube OAUTH</button>';
    
    return $field;
}

add_filter('acf/load_field/key=field_5f5b2c38ac3a1', 'acf_change_yt_oauth_button_state');