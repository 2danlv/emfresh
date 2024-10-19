<?php

function site_acf_init() {
    acf_update_setting('google_api_key', get_field('google_map_key', 'option') );
}
add_action('acf/init', 'site_acf_init');