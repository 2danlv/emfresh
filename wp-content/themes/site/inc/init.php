<?php


// Get setting theme
require get_theme_file_path( '/inc/admin/setting.php' );


// Functions use in theme
// require get_theme_file_path( '/inc/functions/cf7.php' );
require get_theme_file_path( '/inc/functions/custom.php' );
require get_theme_file_path( '/inc/functions/tinymce-advanced.php' );
require get_theme_file_path( '/inc/functions/menu.php' );
// require get_theme_file_path( '/inc/functions/seo.php' );

// require get_theme_file_path( '/inc/functions/Hoper_Wish_Walker_Nav_Menu.php' );
// require get_theme_file_path( '/inc/functions/template-tags.php' );

// Custom type
require get_theme_file_path( '/inc/post_types/customer.php' );
require get_theme_file_path( '/inc/post_types/info.php' );
