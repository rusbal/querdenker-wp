<?php
/**
 * All hooks for the theme.
 *
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0
 */          
 
function yiw_add_sphere_class( $html ) {
    return str_replace( '"box-post-thumb"', '"box-post-thumb sphere"', $html );    
}
add_filter( 'yiw_sc_recentpost_html', 'yiw_add_sphere_class' );
add_filter( 'yiw_sc_last_news_html',  'yiw_add_sphere_class' );

?>