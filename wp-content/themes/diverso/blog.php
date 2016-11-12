<?php
/**
 * @package WordPress
 * @since 1.0
 */
 
/*
Template Name: Blog
*/

wp_enqueue_style( 'Oswald', 'http://fonts.googleapis.com/css?family=Oswald&v2' ); 

global $blog_type;
$blog_type = yiw_get_option( 'blog_type' );
                                                       
get_header() ?>           
        
        <?php global $paged ?>
        <?php query_posts('cat=' . yiw_get_option( 'blog_category', yiw_get_exclude_categories() ) . '&posts_per_page=' . get_option('posts_per_page') . '&paged=' . $paged) ?>
        
        <div id="content" class="layout-<?php echo yiw_layout_page() ?> group">      
		
		    <?php get_template_part( 'slogan' ) ?>   
        
            <!-- START CONTENT -->
            <div id="primary" class="group">
                <?php get_template_part( 'loop', 'index' ) ?>
            </div>                       
            <!-- END CONTENT -->
            
            <!-- START SIDEBAR -->
            <?php get_sidebar( 'blog' ) ?>  
            <!-- END SIDEBAR -->  
        
        </div>   
                              
        <!-- START EXTRA CONTENT -->
		<?php get_template_part( 'extra-content' ) ?>      
        <!-- END EXTRA CONTENT -->      
        
<?php get_footer() ?>
