    <?php //if ( get_the_content( $GLOBALS['yiw_ID'] ) == '' ) return; ?>
    
    <div id="content" class="gradient layout-<?php echo yiw_layout_page() ?> group">  
    
        <div class="top shadow"></div>   
    
        <?php get_template_part( 'slogan' ) ?>
        
        <!-- START CONTENT -->
        <div id="primary" class="hentry group wrapper-content" role="main">
            <?php 
				if ( is_home() )
					get_template_part( 'loop', 'index' ); 
				else
					get_template_part( 'loop', 'page' ); 
			?> 
        </div>
        <!-- END CONTENT -->
        
        <!-- START SIDEBAR -->
        <?php get_sidebar() ?>
        <!-- END SIDEBAR -->   
        
        <!-- START EXTRA CONTENT -->
		<?php get_template_part( 'extra-content' ) ?>      
        <!-- END EXTRA CONTENT -->  
    
    </div> 