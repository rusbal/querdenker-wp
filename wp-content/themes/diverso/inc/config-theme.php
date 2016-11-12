<?php
/**
 * COnfiguration of the theme 
 * 
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0 
 */ 
 
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 620;   

define( 'YIW_THEME_NAME', 'Diverso' ); // The theme name
define( 'YIW_THEME_FOLDER_NAME', 'diverso' ); // The theme folder name
define( 'NOTIFIER_XML_FILE', 'http://update.yithemes.com/diverso-free.xml' ); // The remote notifier XML file containing the latest version of the theme and changelog

// minimum version compatible with the theme
define( 'YIW_MINIMUM_WP_VERSION', '3.1' );

// default layout page
define( 'YIW_DEFAULT_LAYOUT_PAGE', 'sidebar-right' );    


/**
 * The items of Theme Options. The ID of each item, must be the same with the name of own file options (except -options.php), 
 * into the "inc/options" folder.
 */ 
$yiw_theme_options_items = array( 
	'general' => __( 'General', 'yiw' ), 
	'home'    => __( 'Home', 'yiw' ),     
	'premium' => __( 'Premium', 'yiw' )
);               

$yiw_sliders = array(
	'none'         => __( 'None', 'yiw' ),
	'fixed-image'  => __( 'Fixed Image', 'yiw' )
);      

$yiw_portfolio_type = array(
    '3cols'      => __('3 Columns', 'yiw'), 
    'slider'     => __('With Slider', 'yiw'),
    'big_image'  => __('Big Image', 'yiw'), 
    'full_desc'  => __('Full Description', 'yiw'), 
    'filterable' => __('Filterable', 'yiw'), 
);

// default contact form
$yiw_default_contact_form = array(
	array (
        'title' => 'Name',
        'data_name' => 'name',
        'description' => '',
        'type' => 'text',
        'label_checkbox' => '',
        'msg_error' => 'Insert the name',
        'required' => 'yes',
        'class' => '',
    ),

    array (
        'title' => 'Email',
        'data_name' => 'email',
        'description' => '',
        'type' => 'text',
        'label_checkbox' => '',
        'msg_error' => 'Insert a valid email',
        'required' => 'yes',
        'email_validate' => 'yes',
        'reply_to' => 'yes',
        'class' => '',
    ),

    array (
        'title' => 'Message',
        'data_name' => 'message',
        'description' => '',
        'type' => 'textarea',
        'label_checkbox' => '',
        'msg_error' => 'Insert a message',
        'required' => 'yes',
        'class' => '',
    )
);

define( 'YIW_DEFAULT_CONTACT_FORM', serialize( $yiw_default_contact_form ) );


// define the links to rss url for dashboard
define( 'YIW_RSS_FORUM_URL', 'http://www.yourinspirationweb.com/tf/support/forum/feed.php?fid=3' );
define( 'YIW_RSS_URL', 'http://feeds.feedburner.com/yourinspirationweb/HuJt' );
?>