<?php   

$yiw_home_sections = array(
   'home-row' => __( 'Home Row', 'yiw' ),
   'sections' => __( 'Sections', 'yiw' ),
   'content' => __( 'Page Content', 'yiw' ),
   'testimonials' => __( 'Testimonials Slider', 'yiw' ),
);             

$yiw_options['home'] = array (
	 
	/* =================== SECTION 1 =================== */
    'title' => array(    
        array( 'name' => __('Home Sections', 'yiw'),
        	   'type' => 'title'),
    ),   
    
                                                      
    /* =================== TESTIMONIAL =================== */
    'testimonials' => array(
        array( 'name' => __('Testimonials Slider', 'yiw'),
        	   'type' => 'section'),
        array( 'type' => 'open'),        
        	
        array( 'name' => __('Show testimonials slider', 'yiw'),
        	   'desc' => __('Say if you want the testimonials slider on home page.', 'yiw'),
        	   'id' => 'show_testimonials_slider',     
        	   'type' => 'on-off',
        	   'std' => 1),     
         
        array( 'name' => __('Items', 'yiw'),
        	   'desc' => __('How many tweets to include into the slider.', 'yiw'),
        	   'id' => 'testimonials_items',
        	   'type' => 'slider_control',  
        	   'min' => 0,
        	   'max' => 20,
        	   'std' => 5),   	
        	
        array( 'name' => __('Speed (s)', 'yiw'),
        	   'desc' => __('Select the speed of transiction between slides, expressed in seconds.', 'yiw'),
        	   'id' => 'testimonials_speed',
        	   'min' => 0,
        	   'max' => 5,
        	   'step' => 0.1,
        	   'type' => 'slider_control',
        	   'std' => 0.5),  
        	
        array( 'name' => __('Timeout (s)', 'yiw'),
        	   'desc' => __('Select the delay between slides, expressed in seconds.', 'yiw'),
        	   'id' => 'testimonials_timeout',
        	   'min' => 0,
        	   'max' => 20,
        	   'step' => 0.5,
        	   'type' => 'slider_control',
        	   'std' => 5),      
         
        array( 'type' => 'close')   
    ),          
    /* =================== END TWITTER =================== */  
);   
?>