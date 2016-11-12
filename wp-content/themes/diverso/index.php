<?php
/**
 * @package WordPress
 * @since 1.0
 */

wp_enqueue_style( 'Oswald', 'http://fonts.googleapis.com/css?family=Oswald&v2' );  

global $blog_type;
$blog_type = yiw_get_option( 'blog_type' );

get_header() ?>           
        
        <div id="content" class="layout-<?php echo yiw_layout_page() ?> group">
        
            <!-- START CONTENT -->
            <div id="primary" class="group">
                <?php get_template_part( 'loop', 'index' ) ?>
            </div>                       
            <!-- END CONTENT -->
            
            <!-- START SIDEBAR -->
            <?php get_sidebar( 'blog' ) ?>  
            <!-- END SIDEBAR -->  
        
        </div>    
        
<?php get_footer() ?>