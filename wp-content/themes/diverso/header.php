<?php
/**
 * The Header for our theme.
 *
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0
 */
 
 global $yiw_mobile;
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php if ( ! $yiw_mobile->isIpad() ) : ?>
<meta name="viewport" content="width=device-width" />
<?php endif ?>
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged, $shortname, $post;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );
	
	// Add description, if is home
	if ( is_home() || is_front_page() )
		echo ' | ' . get_bloginfo( 'description' );

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'yiw' ), max( $paged, $page ) );

	?></title>
	
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	
	<?php if ( yiw_get_option( 'responsive', 1 ) ) : ?>
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 960px)" href="<?php echo get_template_directory_uri(); ?>/css/lessthen800.css" />
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 600px)" href="<?php echo get_template_directory_uri(); ?>/css/lessthen600.css" />
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 480px)" href="<?php echo get_template_directory_uri(); ?>/css/lessthen480.css" />
	<?php endif; ?>
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    
    <?php
		// styles 
        wp_enqueue_style( 'prettyPhoto',        get_template_directory_uri()."/css/prettyPhoto.css" ); 
        wp_enqueue_style( 'jquery-tipsy',        get_template_directory_uri()."/css/tipsy.css" );  
		wp_enqueue_style( 'Droid-google-font',  'http://fonts.googleapis.com/css?family=Droid+Sans' );  
        wp_enqueue_style( 'Yanone-google-font', 'http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200,400' );      
                                             
		// scripts 
        wp_enqueue_script( 'jquery-easing' );
        wp_enqueue_script( 'jquery-prettyPhoto' );
        wp_enqueue_script( 'jquery-tipsy' );  
        wp_enqueue_script( 'jquery-tweetable' );           
        wp_enqueue_script( 'jquery-cycle' );  
		wp_enqueue_script( 'jquery-nivo' );
		wp_enqueue_script( 'jquery-flexislider',        get_template_directory_uri()."/js/jquery.flexslider.min.js" );

        // custom
        wp_enqueue_script( 'jquery-custom', get_template_directory_uri()."/js/jquery.custom.js", array('jquery'), '1.0', true);
		
		$src = get_post_meta( get_the_ID(), '_map_url', true );
        if ( get_post_meta( get_the_ID(), '_show_map', true ) == 'yes' && ! empty( $src ) ) 
    		wp_localize_script( 'jquery-custom', 'header_map', array(
            	'tab_open'  => __( 'View map', 'yiw' ),
            	'tab_close' => __( 'Close map', 'yiw' ),
            ) );
		                   
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );        
                                                                
        $body_class = '';
        if ( ( yiw_get_option( 'responsive', 1 ) && ! $GLOBALS['is_IE'] ) || ( yiw_get_option( 'responsive', 1 ) && yiw_ieversion() >= 9 ) )   
            $body_class = ' responsive';                                                 
    ?>         

    <!-- [favicon] begin -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php yiw_favicon(); ?>" />
    <link rel="icon" type="image/x-icon" href="<?php yiw_favicon(); ?>" />
    <!-- [favicon] end -->  
    
    <?php wp_head() ?>
</head>

<body <?php body_class( "no_js image-" . yiw_get_option( 'images_style', 'sphere' ) . '-style' . $body_class ) ?>>   
                             
	<!-- START SHADOW WRAPPER -->
	<div class="shadowBg group">       
                             
    	<!-- START WRAPPER -->
    	<div class="wrapper group">          
    	    <?php get_template_part( 'topbar' ); ?>    
            
    	    <!-- START HEADER -->
    	    <div id="header" class="group">            
    	        
    	        <!-- START LOGO -->
    	        <div id="logo" class="group">
    	            
    	            <a href="<?php echo home_url() ?>" title="<?php bloginfo('name') ?>"> 
    	                
    	                <img src="<?php yiw_logo() ?>" alt="Logo <?php bloginfo('name') ?>" />
    	            
    	            </a>              
    	        
    	        </div>
    	        <!-- END LOGO -->   
                
                <!-- START NAV -->
    	        <div id="nav" class="group">
    	            <?php  
    					$nav_args = array(
    	                    'theme_location' => 'nav',
    	                    'container' => 'none',
    	                    'menu_class' => 'level-1 ' . yiw_get_option( 'color_dropdown', 'black' ),
    	                    'depth' => 3,   
    	                    //'fallback_fb' => false,
    	                    //'walker' => new description_walker()
    	                );
    	                
    	                wp_nav_menu( $nav_args ); 
    	            ?>    
    	        </div>
    	        <!-- END NAV -->   
    	    
    	    </div>   
    	    <!-- END HEADER -->
    	    
    	    <?php get_template_part( 'slider' ); ?> 