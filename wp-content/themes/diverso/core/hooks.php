<?php
/**
 * All hooks for the core.
 *
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0
 */                

add_action( 'admin_notices', 'warning_version_wp' ); 		// advise for minimum verison of wp compatible with the theme
add_action( 'after_setup_theme', 'yiw_theme_setup' );   	// theme setup     
add_filter( 'wp_title', 'yiw_get_removeTags' );             // remove the brackets from wp title     
add_filter( 'bloginfo', 'yiw_get_convertTags' );            // convert the words within the brackets, for all blog informations  
add_filter( 'clean_url', 'yiw_ssl_url' );    
                                           

// WP HEAD
// -----------------------------------------------------------

add_action( 'yiw_custom_styles', 'yiw_container_width' );		// the main width of container         
//add_action( 'wp_head', 'yiw_css_custom', 99 );   	// all css customizations      
                                           

// WP FOOTER
// -----------------------------------------------------------
                                                                         
add_action( 'wp_footer', 'yiw_ga_code', 99 );
add_action( 'wp_footer', 'yiw_custom_js', 999 );    // custom js script  
   
		                                   

// SHORTCODES
// -----------------------------------------------------------

add_filter( 'widget_text', 'do_shortcode' );        	// Allow shortcodes in sidebar widgets 
add_filter( 'wp_get_attachment_link', 'yiw_add_lightbox', 10, 6 );  // add the lightbox to the wordpress gallery



// WIDGETS
// -----------------------------------------------------------
                                                               
add_filter( 'widget_title', 'yiw_get_convertTags' );        
add_filter( 'dynamic_sidebar_params', 'yiw_widget_first_last_classes' );  


// ADMIN PANEL
// -----------------------------------------------------------
                                                                         
add_action( 'wp_dashboard_setup', 'yiw_dashboard_widget_setup' );   // Add some widgets for dashboard

// Theme Options
add_action( 'admin_menu', 'yiw_add_admin');    
add_action( 'admin_init', 'yiw_add_styles');  
add_action( 'admin_enqueue_scripts', 'yiw_add_scripts');   


// additional hooks
include_once YIW_THEME_FUNC_DIR . 'hooks.php';

?>