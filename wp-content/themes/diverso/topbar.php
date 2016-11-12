    <?php global $current_user; if( ! yiw_get_option( 'show_topbar' ) ) return; ?>
    
    <!-- START TOPBAR -->
    <div id="topbar">
		<div class="inner" style="text-align:<?php echo yiw_get_option( 'topbar_align', 'right' ) ?>">
		
		    <?php yiw_breadcrumb() ?>
		    
    		<ul class="topbar_links">               
    			<?php do_action( 'yiw_before_render_topbar' ) ?>    
    			
    			<?php if ( yiw_get_option( 'show_login_topbar' ) ) : ?>
	        	<li>
	        		<?php if ( $current_user->ID != 0 ) : ?>                       
					<a href="<?php echo wp_logout_url( yiw_curPageURL() ); ?>"><?php _e('Logout', 'yiw') ?></a>
					<?php else : ?>      
					<a href="<?php echo wp_login_url( yiw_curPageURL() ); ?>"><?php _e('Login', 'yiw') ?></a>  
					<?php endif; ?>
				</li>
                <?php endif;
	        	
					$args = array(
						'container' => 'none', 
						'fallback_cb' => 'wp_page_menu', 
						'items_wrap' => '%3$s',
						'before' => ' | ',
        				'depth' => 1, 
						'theme_location' => 'topbar',
						'fallback_cb' => ''
					);
					
					wp_nav_menu( $args );
				
                    do_action( 'yiw_after_render_topbar' ) ?>  
    	    </ul>        
        
		<div class="clear"></div>		
		</div><!-- end.inner -->
	</div>            
    <!-- END TOPBAR -->