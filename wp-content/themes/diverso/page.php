<?php
/**
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0
 */                        

get_header() ?>                        
        
		<div id="content" class="layout-<?php echo yiw_layout_page() ?> group">
		
		    <?php get_template_part( 'slogan' ) ?>            
			
			<?php get_template_part( 'accordion-slider' ) ?>  
        
            <!-- START CONTENT -->
            <div id="primary" class="group">
                <?php get_template_part( 'loop', 'page' ) ?> 
                
                <?php comments_template() ?>
            </div>
            <!-- END CONTENT -->
            
            <!-- START SIDEBAR -->
            <?php get_sidebar() ?>
            <!-- END SIDEBAR -->    
        
        </div>   
                              
        <!-- START EXTRA CONTENT -->
		<?php get_template_part( 'extra-content' ) ?>      
        <!-- END EXTRA CONTENT -->    
        
<?php get_footer() ?>
