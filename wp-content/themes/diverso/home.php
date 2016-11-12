<?php
/**
 * @package WordPress
 * @subpackage Beauty & Clean
 * @since 1.0
 */
 
/*
Template Name: Home
*/

global $wp_query;      

if ( ( is_home() || is_front_page() ) && get_option( 'show_on_front' ) == 'posts' || $wp_query->is_posts_page ) {
    global $yiw_is_posts_page;
    $yiw_is_posts_page = true;
    get_template_part( 'blog' ); 
    die;
}             
                    
global $yiw_show_slogan, $yiw_home_sections; 
$yiw_show_slogan = false;

get_header(); 
                    
    $elements = 'home-row, content, testimonials';
    
    if ( is_string( $elements ) ) {
        $items = explode( ',', $elements ); 
        $elements = array();
        foreach ( $items as $item ) {
            $item = trim($item);
            $elements[] = array(
                'slug' => $item,
                'name' => $yiw_home_sections[$item],
                'visible' => 'yes'
            );
        }
    }
    
    if ( ! yiw_get_option( 'show_testimonials_slider' ) )
        unset( $elements[2] );
    
    foreach ( $elements as $element ) {
    
        if ( $element['visible'] == 'no' )
            continue;
    
        switch ( $element['slug'] ) {
        
            case 'home-row' :
                get_template_part( 'home', 'row' );        // this contain the slogan, but it will be shown only if it's not shown yet
                break;
            
            case 'content' :   
                get_template_part( 'home', 'content' );     // this contain the slogan, but it will be shown only if it's not shown yet
                break;      
            
            case 'testimonials' :
                get_template_part( 'home', 'testimonials' );
                break;  
                 
        }
        
    }

get_footer() ?>