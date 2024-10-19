<?php

function site_customize_register( $wp_customize ) 
{

    $wp_customize->add_section('site_info_scheme', array(
        'title'    => __('Information', 'vncp'),
        'description' => '',
        'priority' => 120,
    ));
 
    //  =============================
    //  = Text Input                =
    //  =============================
    $wp_customize->add_setting('site_theme_options[ベトナム語]', array(
        'default'        => 'value_xyz',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control('site_ベトナム語', array(
        'label'      => __('ベトナム語', 'vncp'),
        'section'    => 'site_info_scheme',
        'settings'   => 'site_theme_options[ベトナム語]',
    ));


    
}
// add_action( 'customize_register', 'site_customize_register' );