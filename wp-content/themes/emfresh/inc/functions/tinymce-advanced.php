<?php

// The following will reveal the hidden "Styles" dropdown in the advanced toolbar.
function site_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
// add_filter('mce_buttons_2', 'site_mce_buttons_2');

// Callback function to filter the MCE settings
function site_mce_custom_styles( $settings ) {
    
    // Style : editor/editor.scss

    $heading_2 = array();
    for( $i = 1; $i <= 1; $i ++ ) {
        // These are the custom styles
        $heading_2[] = array(  
            'title' => 'Style ' . $i,
            'block' => 'h2',
            'classes' => 'heading2 heading2-0' . $i,
        );
    }

    $heading_3 = array();
    for( $i = 1; $i <= 1; $i ++ ) {
        // These are the custom styles
        $heading_3[] = array(
            'title' => 'Style ' . $i,
            'block' => 'h3',
            'classes' => 'heading3 heading3-0' . $i,
        );
    }

    $colors = array(
        array(
            'title' => 'Gray',
            'format' => 'span',
            'classes' => 'gray',
        ),
        array(
            'title' => 'Green',
            'format' => 'span',
            'classes' => 'green',
        ),
        array(
            'title' => 'Green 1',
            'format' => 'span',
            'classes' => 'green-1',
        ),
        array(
            'title' => 'Green 2',
            'format' => 'span',
            'classes' => 'green-2',
        ),
    );

    $uls = array(
        array(
            'title' => 'Privacy',
            'selector' => 'ul',
            'classes' => 'list-style-privacy',
        ),
    );

    $list_p = array();

    for( $i = 1; $i <= 3; $i ++ ) {
        // These are the custom styles
        $list_p[] = array(
            'title' => 'Line ' . $i,
            'block' => 'p',
            'classes' => 'line-' . $i,
        );
    }

    $style_formats = array(
        /*
        array(
            'title' => 'Heading 1',
            'format' => 'h1',
        ),        
        array(
            'title' => 'Heading 2',
            'items' => $heading_2,
        ),
        array(
            'title' => 'Heading 3',
            'items' => $heading_3,
        ),
        */
        // array(
        //     'title' => 'Div',
        //     'format' => 'div',
        // ),
        // array(
        //     'title' => 'Text Color',
        //     'items' => $colors,
        // ),
        array(
            'title' => 'List',
            'items' => $uls,
        ),

        // array(
        //     'title' => 'Heading 2',
        //     'block' => 'h2',
        //     'classes' => 'heading2 heading2-01',
        // ),
        // array(
        //     'title' => 'Heading 3',
        //     'block' => 'h3',
        //     'classes' => 'heading3 heading3-01',
        // ),
        // array(
        //     'title' => 'List Number',
        //     'selector' => 'ol',
        //     'classes' => 'list-style-number',
        // ),
        // array(
        //     'title' => 'List Circle',
        //     'selector' => 'ul',
        //     'classes' => 'list-style-circle',
        // ),
        // array(
        //     'title' => 'Josefin Sans',
        //     'selector' => 'strong',
        //     'classes' => 'f-josefin',
        // ),
        // array(
        //     'title' => 'Spacing',
        //     'inline' => 'true',
        //     'selector' => 'span',
        //     'classes' => 'spacing',
        // ),
        // array(
        //     'title' => 'Paragraph',
        //     'items' => $list_p,
        // ),
        array(
            'title' => 'C Heading 1',
            'block' => 'h1',
            'classes' => 'c-heading-1',
        ),
        array(
            'title' => 'C Heading 2',
            'block' => 'h2',
            'classes' => 'c-heading-2',
        ),
    );

    // https://www.tiny.cloud/docs/configure/content-formatting/#formats
    // Insert the array, JSON ENCODED, into 'style_formats'
    $settings['style_formats'] = json_encode( $style_formats );

    // Classes for table
    $table_class_list = array(
        array(
            'title' => 'Default',
            'value' => '',
        ),
        array(
            'title' => 'Charts - Benefits',
            'value' => 'table-charts',
        ),

    );

    // https://www.tiny.cloud/docs/plugins/table/#table_class_list
    $settings['table_class_list'] = json_encode( $table_class_list );


    // List color
    $color_map = array(
        '000000' => 'Black',
        'ffffff' => 'White',
        '666666' => 'Gray',
        '1c4a1f' => 'Green 1',
        '438d46' => 'Green 2',
        '082d0a' => 'Green 3',
    );

    // https://www.tiny.cloud/docs/configure/content-appearance/#color_map
    // $settings['color_map'] = json_encode( $color_map ); // currently can not use


    $link_class_list  = array(
        array(
            'title' => 'None',
            'value' => '',
        ),
        // array(
        //     'title' => 'Popup View 360',
        //     'value' => 'jpopup-view-360-button',
        // ),
        array(
            'title' => 'PDF',
            'value' => 'link-pdf',
        ),
        array(
            'title' => 'Blank',
            'value' => 'link-blank',
        ),
        // array(
        //     'title' => 'More',
        //     'value' => 'link-more',
        // ),
    );

    // https://www.tiny.cloud/docs/plugins/link/#link_class_list
    $settings['link_class_list'] = json_encode( $link_class_list );

    $image_list  = array(
        array(
            'title' => 'None',
            'value' => '',
        ),
        array(
            'title' => 'Testing',
            'value' => 'testing',
        ),
    );

    // https://www.tiny.cloud/docs/plugins/image/
    // $settings['image_list'] = json_encode( $image_list ); // currently can not use
    
    return $settings;
}
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'site_mce_custom_styles' );