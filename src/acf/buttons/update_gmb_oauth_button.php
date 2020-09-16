<?php

function acf_change_gmb_oauth_button_state( $field ) {

    /**
     * Update CSS class if refresh token found.
     */
    if (false !== (get_transient( 'GMB_OAUTH_REFRESH_TOKEN' ))) {
        $field['wrapper']['class'] = 'enabled';
        $field['message'] = str_replace('>GMB OAuth<', '>Refresh Token Found<', $field['message']);
        return $field;
    }

    /**
     * Default.
     */
    $field['wrapper']['class'] = ""; // remove 'enabled'
    $field['message'] = '<button type="button" class="button-secondary" id="acf__gmb-oauth">GMB OAuth</button>';
    
    return $field;
}

add_filter('acf/load_field/key=field_5f60f9899763c', 'acf_change_gmb_oauth_button_state');