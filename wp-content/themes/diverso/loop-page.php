<?php
	global $wp_query, $post;
	
	wp_reset_query();
	
	$tmp_query = $wp_query;
	
	if ( have_posts() ) : 

	    while ( have_posts() ) : the_post();
	    	
			add_filter( 'the_title', 'yiw_get_convertTags' ); 
			
			$_active_title = get_post_meta( $post->ID, '_show_title_page', true );
			
			if( $_active_title == 'yes' || !$_active_title ) 
				the_title( '<h2>', '</h2>' );     
			?>	
			
			<div id="post-<?php the_ID(); ?>" <?php post_class('group'); ?>><?php
				the_content();?>
			</div><?php
		
		endwhile; 
	
	endif; 
	
	$wp_query = $tmp_query;      
	
	wp_reset_postdata();
?>                    