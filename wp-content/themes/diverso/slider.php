<?php 
    global $wp_query;
    if( ( is_home() || is_front_page() || is_page_template('home.php') ) && ! $wp_query->is_posts_page )
        get_template_part( 'slider', 'fixed-image' ); 
?>