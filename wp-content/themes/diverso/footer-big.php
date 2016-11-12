                    <?php if ( yiw_get_option( 'show_footer' ) ) : ?>
			        <!-- START FOOTER -->
			        <div id="footer" class="group columns-<?php echo yiw_get_option( 'footer_columns' ); ?>">
				    	
				    	<div class="inner">
				    	
							<div class="footer-main">
								<?php dynamic_sidebar( 'Footer Row' ) ?>
							</div>
				        
				        </div>
								    
					</div>       
			        <!-- END FOOTER -->
			        <?php endif; ?>