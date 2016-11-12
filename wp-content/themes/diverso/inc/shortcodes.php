<?php
/**
 * Additional shortcodes for the theme.
 * 
 * To create new shortcode, get for example the shortcode [sample] already written.
 * Replace it with your code for shortcode and for other shortcodes, duplicate the first
 * and continue following.
 * 
 * CONVENTIONS: 
 * - The name of function MUST be: yiw_sc_SHORTCODENAME_func.
 * - All html output of shortcode, must be passed by an hook: apply_filters( 'yiw_sc_SHORTCODENAME_html', $html ).
 * NB: SHORTCODENAME is the name of shortcode and must be written in lowercase.    
 * 
 * For example, we'll add new shortcode [sample], so:
 * - the function must be: yiw_sc_sample_func().
 * - the hooks to use will be: apply_filters( 'yiw_sc_sample_html', $html ).   
 * 
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0 
 */    
 
 
/** 
 * testimonials   
 * 
 * @description
 *    Show all post on testimonials post types    
 * 
 * @example
 *   [testimonials items=""]
 *   
 * @params
 *      items - number of item to show   
 * 
**/

function yiw_sc_testimonials_func($atts, $content = null) {        
    extract(shortcode_atts(array(
        "items" => null
    ), $atts));    

    wp_reset_query();    

    $args = array(
        'post_type' => 'bl_testimonials'  
    );

    $args['posts_per_page'] = ( !is_null( $items ) ) ? $items : -1;

    $tests = new WP_Query( $args );   

    $html = '';

    if( !$tests->have_posts() ) return $html;

    //loop         
    $html = '';
    while( $tests->have_posts() ) : $tests->the_post();

        $title = the_title( '<span class="title special-font">', '</span>', false );
        $website = get_post_meta( get_the_ID(), '_testimonial_website', true ); 
        $label = get_post_meta( get_the_ID(), '_testimonial_label', true ) ? get_post_meta( get_the_ID(), '_testimonial_label', true ) : str_replace('http://', '', $website); 
        if ( ! empty( $website ) )
            $website = "<a href=\"" . esc_url( $website ) . "\">". $label  ."</a>"; 
        else
            $website = $label;    
        
        $thumb = get_the_post_thumbnail( null, 'testimonial-page-thumb' );
        $class_thumb = ( has_post_thumbnail() && ! empty( $thumb ) ) ? '' : ' no-thumb';  

        $html .= '<div class="testimonials-list' . $class_thumb . ' group">'; 

        $html .= '  <div class="thumb-testimonial group">';    
        $html .= '      <div class="sphere">' . $thumb . '</div>';   
        //$html .= '      <div class="shadow-thumb"></div>'; 
        $html .= '      <p class="name-testimonial group">' . $title . '<span class="website">' . $website . '</span></p>'; 
        $html .= '  </div>'; 

        $content = wpautop( get_the_content() );

        $html .= '  <div class="the-post group">';    
        $html .= '      ' . $content; 
        $html .= '  </div>';               

        $html .= '</div>';

    endwhile;          

    return apply_filters( 'yiw_sc_testimonials_html', $html );
}       
add_shortcode("testimonials", "yiw_sc_testimonials_func");            

/** 
 * Faqs    
 * 
 * @description
 *    Show all post on faq post types    
 * 
 * @example
 *   [faq items=""]
 *   
 * @params
 *      items - number of item to show   
 * 
**/
function yiw_sc_faq_func($atts, $content = null) {        
    extract(shortcode_atts(array(
        "items" => -1,
        "close_first" => false
    ), $atts));
    
    $args = array(
        'post_type' => 'bl_faq',
        'posts_per_page' => $items 
    );
    
    $faqs = new WP_Query( $args );       
    
    $first = TRUE;
    if( $close_first ) $first = FALSE;
    
    $html = '';
    if( !$faqs->have_posts() ) return $html;
    
    //loop
    while( $faqs->have_posts() ) : $faqs->the_post();
    
        $title = the_title( '', '', false );
        $content = get_the_content();
        
        $attr = '';
        if( $first )
            $attr = ' opened="1"';
        
        $html .= do_shortcode( "[toggle title=\"$title\"{$attr}]{$content}[/toggle]" );
        $first = FALSE; 
    
    endwhile;          
    
    return apply_filters( 'yiw_sc_faq_html', $html );
}             
add_shortcode("faq", "yiw_sc_faq_func");      


/** 
 * TOGGLE     
 * 
 * @description
 *    Create a toggle content.    
 * 
 * @example
 *   [toggle title="" opened=""]text[/toggle]
 * 
 * @attr  
 *   title - the title of toggle content   
 *   text - the text
**/
function yiw_sc_toggle_func($atts, $content = null) {        
    extract(shortcode_atts(array(
        "title" => null,
        "opened" => false
    ), $atts));
    
    $content = wpautop( $content );
    
    $class = 'closed';
    if( $opened )
        $class = 'opened';
    
    $html = '<div class="toggle">
                <p class="tab-index tab-'.$class.'"><a href="#" title="Close">'.$title.'</a></p>
                <div class="content-tab '.$class.'">
                    <div class="arrow">&nbsp;</div>
                    '.yiw_addp($content).'
                </div>  
            </div>';
    
    return apply_filters( 'yiw_sc_toggle_html', $html );
}              
add_shortcode("toggle", "yiw_sc_toggle_func");    

?>