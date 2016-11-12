            <?php get_template_part( 'footer', 'twitter' ); ?>
            
            <?php get_template_part( 'footer', 'big' ); ?>
            	
            <?php $copyright_type = yiw_get_option( 'copyright_type' ); ?>
			        
	        <!-- START COPYRIGHT -->
	        <div id="copyright" class="group <?php echo $copyright_type ?>">
	        
	             <div class="inner group">
	        
			        <?php if( $copyright_type == 'two-columns' ) : ?>
			        
			            <?php yiw_string_( '<p class="left">', yiw_get_convertTags( do_shortcode( stripslashes( yiw_get_option( 'copyright_text_left', 'Copyright <a href="%site_url%"><strong>%name_site%</strong></a> 2010' ) ) ) ), '</p>' ) ?>
			            
			            <?php yiw_string_( '<p class="right">', yiw_get_convertTags( do_shortcode( stripslashes( yiw_get_option( 'copyright_text_right', 'Powered by <a href="http://www.yourinspirationweb.com/en"><strong>Your Inspiration Web</strong></a>' ) ) ) ), '</p>' ) ?>  
			            
			        <?php elseif( $copyright_type == 'centered' ) : ?> 
			        
			            <!-- START NAVIGATION -->
            		    <?php 
            				$options = array(
            		            'theme_location' => 'footer-nav',
            		            'containter' => 'none',
            		            'menu_id' => 'footer-nav',
            		            'fallback_cb' => '',
            		            'depth' => 1
            		        );
            		        
            		        wp_nav_menu( $options )
            			?>
            		    <!-- END NAVIGATION --> 
			            
			            <p class="center">
		                	<?php yiw_convertTags( do_shortcode( stripslashes( yiw_get_option( 'copyright_text_centered' ) ) ) ) ?>  
			            </p>
			            
			        <?php endif ?>   
	        
	             </div>
	        
	        </div>
	        <!-- END COPYRIGHT -->     
	    
		</div>     
	    <!-- END WRAPPER --> 	    
	    
	</div>     
    <!-- END SHADOW -->  
    
	<?php wp_footer() ?>   
	
	</body>

</html>