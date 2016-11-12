<?php
    $show = get_post_meta( get_the_ID(), '_show_footer_twitter', true );  
    if ( ( ! empty( $show ) && $show == 'no' ) || ( empty( $show ) && ! yiw_get_option( 'show_footer_twitter' ) ) )
        return;
?>                    
                    
                    <!-- START TWITTER -->
			        <div id="twitter-slider" class="group">
				    	
				        <div class="tweets-list"></div>
                        
                        <div class="bird"></div>
                        
                        <script type="text/javascript">
                            jQuery(function($){         
                                
                                var twitterSlider = function(){      
//                                     $('#twitter-slider .tweets-list ul').cycle({
//                                         fx : 'scrollVert',
//                                         speed: <?php echo yiw_get_option( 'twitter_speed' ) * 1000 ?>,
//                                         timeout: <?php echo yiw_get_option( 'twitter_timeout' ) * 1000 ?>
//                                     });
                                    $('.tweets-list ul').addClass('slides');
                                    $('.tweets-list').flexslider({
                                        animation: "slide",
                                        slideDirection: "vertical",
                                        slideshowSpeed: <?php echo yiw_get_option( 'twitter_timeout' ) * 1000 ?>,
                                        animationDuration: <?php echo yiw_get_option( 'twitter_speed' ) * 1000 ?>,
                                        directionNav: false,             
                                        controlNav: false,             
                                        keyboardNav: false
                                    });
                                };
                                
                                $('#twitter-slider .tweets-list').tweetable({
                                    username: '<?php echo yiw_get_option( 'twitter_username' ) ?>',
                                    items: <?php echo yiw_get_option( 'twitter_items' ) ?>,
                                    time: true,
                                    loaded: twitterSlider
                                });     
                            });
                        </script>	
								    
					</div>       
			        <!-- END FOOTER -->