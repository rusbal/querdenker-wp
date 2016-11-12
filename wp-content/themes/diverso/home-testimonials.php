<?php 

$args = array(
    'post_type' => 'bl_testimonials',
    'posts_per_page' => -1
);

$tests = new WP_Query( $args ); 

if ( wp_count_posts('bl_testimonials')->publish == 1 )  
    $is_slider = false;
else
    $is_slider = true;
    
if ( ! $tests->have_posts() )
    return;

?>        
   	<div class="testimonials-slider gradient-small group">
   	    <div class="top shadow"></div>
   	    
   	    <div class="testimonial-list">
       	    <ul class="testimonials group">
        
    <?php while( $tests->have_posts() ) : $tests->the_post(); 
                 
                $length = apply_filters( 'yiw_testimonials_length', 12 );
                $length = create_function( '', "return $length;" );
                add_filter('excerpt_length', $length );
                add_filter('excerpt_length', $length );
                $website = get_post_meta( get_the_ID(), '_testimonial_website', true ); ?>
            
                <li>
                    <blockquote><p class="special-font">&rdquo;<?php echo get_the_excerpt() ?>&rdquo;</p></blockquote>
                    <p class="meta"><?php the_title( '<strong>', '</strong>' ) ?> - <a href="<?php echo esc_url( $website ) ?>"><?php echo $website ?></a></p>
                </li>
            
    <?php endwhile; ?>         
            
            </ul> 
            <?php if ( $is_slider ) : ?>
            <div class="prev"></div>
            <div class="next"></div>       
            <?php endif; ?>
        </div> 
            
   	    <div class="bottom shadow"></div>
    </div>          
    
    <?php if ( $is_slider ) : ?>                    
    <script type="text/javascript">
        jQuery(function($){
            $('.testimonials-slider .testimonial-list ul').cycle({
                fx : 'scrollHorz',
                speed: <?php echo yiw_get_option( 'testimonials_speed' ) * 1000 ?>,
                timeout: <?php echo yiw_get_option( 'testimonials_timeout' ) * 1000 ?>,
                next: '.testimonials-slider .testimonial-list .next',
                prev: '.testimonials-slider .testimonial-list .prev'
            });
        });
    </script>	      
    <?php endif; ?>
    
<?php
wp_reset_query();   
?>