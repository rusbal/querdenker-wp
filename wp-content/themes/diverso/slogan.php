		<?php 
		    global $post, $yiw_show_slogan, $yiw_is_posts_page;
            
            $yiw_is_posts_page = ! isset( $yiw_is_posts_page ) ? false : $yiw_is_posts_page;
		                                       
		    if ( ! isset( $yiw_show_slogan ) )
                $yiw_show_slogan = true;
		    else
                $yiw_show_slogan = ! $yiw_show_slogan ? true : false;
		    
		    if ( ! $yiw_show_slogan )
		        return;
		    
		    //$post_id = isset( $post->ID ) ? $post->ID : 0; 
            
            if ( $yiw_is_posts_page )  
                $post_id = get_option( 'page_for_posts' );
            else if ( isset( $post->ID ) )
                $post_id = $post->ID;
            else
                $post_id = 0;      
		                              
            $title =    yiw_translate( get_post_meta( $post_id, '_slogan_page', true ) );
            $subtitle = yiw_translate( get_post_meta( $post_id, '_subslogan_page', true ) );
            
            if ( is_tax() )
                $title = ucfirst( get_queried_object()->name );
            
            if ( ! empty( $title ) ) : 
        ?>
        <div id="slogan" class="inner">
            <?php yiw_string_( '<h1' . ( empty( $subtitle ) ? ' class="only"' : '' ) . '>', yiw_get_convertTags( $title ), '</h1>' ); ?>
            <?php yiw_string_( '<h3>', yiw_get_convertTags( $subtitle ), '</h3>' ); ?>
        </div>
        <?php endif ?>