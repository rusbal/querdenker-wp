<?php
/**
 * Register theme metaboxes.     
 * 
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0
 */
 
// subtitle slogan
$options_args = array(
	11 => array( 
		'id' => 'subslogan_page',
		'name' => __( 'Slogan Subtitle', 'yiw' ), 
		'type' => 'text',
		'desc' => __( 'Insert the subtitle of slogan showed below the main title of this slogan.', 'yiw' ),
		'desc_location' => 'newline'
	),
); 
yiw_add_options_to_metabox( 'yiw_slogan_page', $options_args );

global $yiw_sliders;

$options_args = array(
    21 => array( 
        'id' => 'show_breadcrumb',
        'name' => __( 'Show Breadcrumb', 'yiw' ), 
        'type' => 'radio',
        'options' => array(
            'yes' => __( 'Yes', 'yiw' ),
            'no' => __( 'No', 'yiw' ),  
        ),
        'std' => 'yes',
        'hidden' => false,
        'std' => 'yes'
    ), 

); 
yiw_add_options_to_metabox( 'yiw_options_page', $options_args );  
 
$options_args = array(
	89 => array( 
		'id' => 'show_footer_twitter',
		'name' => __( 'Show twitter above the footer.', 'yiw' ), 
		'type' => 'select',
		'options' => array(
            'yes' => __( 'Yes', 'yiw' ),
            'no' => __( 'No', 'yiw' ),
        ),
		//'hidden' => false,
		//'desc' => __( 'Insert the subtitle of slogan showed below the main title of this slogan.', 'yiw' ),
		//'desc_location' => 'newline'
	),
); 
yiw_add_options_to_metabox( 'yiw_options_page', $options_args );
	
// remove filter wpautop
$options_args = array( 
	10 => array(                          
		'name' => __( 'Name', 'yiw' ), 
		'id' => 'testimonial_label',
		'type' => 'text'
	),
	20 => array(                      
		'name' => __( 'URL', 'yiw' ), 
		'id' => 'testimonial_website',
		'type' => 'text'
	),
); 
yiw_register_metabox( 'yiw_website_testimonial', __( 'Website', 'yiw' ), 'bl_testimonials', $options_args, 'side', 'high' );
?>