<?php
/**
 * The functions of theme 
 * 
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0 
 */                                     
 
 include 'shortcodes.php'; 
 
// default theme setup
function yiw_theme_setup() {     
    global $wp_version;

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style( 'css/editor-style.css' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );  

	// This theme uses the menues
	add_theme_support( 'menus' );          

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// Post Format support.                      
	//add_theme_support( 'post-formats', array( 'aside', 'gallery' ) ); 
	
	// Post Format support.                      
	//add_theme_support( 'post-formats', array( 'aside', 'gallery' ) ); // Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/fixed-images/001.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'yiw_header_image_width', 960 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'yiw_header_image_height', 338 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	//set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	if ( ! defined( 'NO_HEADER_TEXT' ) )
		define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyten_admin_header_style(), below.
    if( version_compare( $wp_version, '3.4', ">=" ) )
        add_theme_support( 'custom-header', array( 'admin-head-callback' => 'yiw_admin_header_style' ) );
    else
        add_custom_image_header( '', 'yiw_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'design1' => array(
			'url' => '%s/images/fixed-images/001.jpg',
			'thumbnail_url' => '%s/images/fixed-images/thumb/001.jpg',
			/* translators: header image description */
			'description' => __( 'Design', 'yiw' ) . ' 1'
		),
		'design2' => array(
			'url' => '%s/images/fixed-images/002.jpg',
			'thumbnail_url' => '%s/images/fixed-images/thumb/002.jpg',
			/* translators: header image description */
			'description' => __( 'Design', 'yiw' ) . ' 2'
		),
		'design3' => array(
			'url' => '%s/images/fixed-images/003.jpg',
			'thumbnail_url' => '%s/images/fixed-images/thumb/003.jpg',
			/* translators: header image description */
			'description' => __( 'Design', 'yiw' ) . ' 3'
		),
	) );

	$locale = get_locale();      
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file ); 
    
	// This theme uses wp_nav_menu() in more locations.
	register_nav_menus(
        array(
            'nav'           => __( 'Navigation', 'yiw' ),
            'topbar'        => __( 'Topbar', 'yiw' ),
        )
    );
    
    // images size
    //add_image_size( 'slider-thumbnails', 110, 64, true );  
    $image_sizes = array(
        'blog_big'              => array( 640, 295, true ),  
        'blog_small'            => array( 288, 266, true ),   
        'testimonial-page-thumb'=> array( 133, 133, true ),   
        'recent-posts-thumb'    => array( 86,  86,  true ),   
        'testimonial-thumb'     => array( 78,  78,  true ) 
    );
    
    foreach ( $image_sizes as $id_size => $size )               
        add_image_size( $id_size, apply_filters( 'yiw_' . $id_size . '_width', $size[0] ), apply_filters( 'yiw_' . $id_size . '_height', $size[1] ), $size[2] ); 
	                                                                                                                       
	register_sidebar( yiw_sidebar_args( 'Default Sidebar', __( 'This sidebar will be shown in all pages with empty sidebar or without any sidebat set.', 'yiw' ) ) );      
	register_sidebar( yiw_sidebar_args( 'Home Row', __( 'The row below home content.', 'yiw' ), 'one-third', 'h3' ) );     
	register_sidebar( yiw_sidebar_args( 'Blog Sidebar', __( 'The sidebar showed on page with Blog template', 'yiw' ) ) );     
	register_sidebar( yiw_sidebar_args( 'Testimonials Sidebar', __( 'The sidebar showed on page with Testimonials pages', 'yiw' ) ) );      
	register_sidebar( yiw_sidebar_args( 'Footer Row', __( 'The footer widgets.', 'yiw' ), 'widget', 'h3' ) );           
    
    do_action( 'yiw_register_sidebars' );                 
}

function yiw_page_menu_submenu_style( $args ) {
    $args['menu_class'] = 'menu ' . yiw_get_option( 'color_dropdown', 'black' );
    return $args;
}
add_filter( 'wp_page_menu_args', 'yiw_page_menu_submenu_style', 1 ); 

if ( ! function_exists( 'yiw_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function yiw_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;     


/** BACKGROUND STYLE
-------------------------------------------------------------------- */

/**
 * Add style of body
 *
 * @since 1.0
 */
function yiw_body_style() {
	
// 	if ( yiw_get_option( 'theme_layout' ) != 'boxed' )
// 		return;
	
	$role = '';
	
	$bg_type = yiw_get_option( 'body_bg_type' );
	$color_bg = yiw_get_option( 'body_bg_color' );
	
	switch ( $bg_type ) {
	
		case 'color-unit' :
			$role = 'background:' . $color_bg . ';';
			break;
	
		case 'bg-image' :
			$image = yiw_get_option( 'body_bg_image', 'custom' );
            
            if ( yiw_get_option( 'theme_layout' ) == 'stretched' )
                $image = 'custom';         
			
			// image
			if ( $image != 'custom' ) {
				$url_image = get_template_directory_uri() . '/' . $image;   
				$position = 'top center'; 
				$repeat = 'repeat';
				$attachment = 'fixed';
			} else {
				$url_image = esc_url( yiw_get_option( 'body_bg_image_custom', '' ) ); 
				$position = yiw_get_option( 'body_bg_image_custom_position' ); 
				$repeat = yiw_get_option( 'body_bg_image_custom_repeat' );
				$attachment = yiw_get_option( 'body_bg_image_custom_attachment' );
			}                      
				
			if ( $url_image != '' )
			    $url_image = " url('$url_image')";
			
			$attrs = array(
                "background-color: $color_bg",
                "background-image: $url_image",
                "background-position: $position",
                "background-repeat: $repeat",
                "background-attachment: $attachment"
            );
			
			$role = implode( ";\n", $attrs );
			break;
	
	}
?>
body, .stretched-layout .bgWrapper {
	<?php echo $role ?>
}
<?php
}   
add_action( 'yiw_custom_styles', 'yiw_body_style' );  


/**
 * Return post content with read more link (if needed)
 * 
 * @param int|string $limit
 * @param string $more_text
 * 
 * @return string
 */
function yiw_content( $limit = 25, $more_text = '' ) {
    $content = get_the_content();     
    $content = explode( ' ', $content );  
/*
    if ( count( $content ) >= $limit ) {
        array_pop( $content );
        if( $more_text != "" )
            $readmore = implode( " ", $content ) . '<a class="read-more" href="' . get_permalink() . '">' . $more_text . '</a>';
        else
            $content = implode( " ", $content ) . ' &#91;...&#93;';
    } else
        $content = implode( " ", $content );    
*/
    if ( ! empty( $more_text ) ) {
        array_pop( $content );
        $more_text = '<a class="read-more" href="' . get_permalink() . '">' . $more_text . '</a>';
    }
    
    // split
    if ( count( $content ) >= $limit ) {
        $split_content = '';
        for ( $i = 0; $i < $limit; $i++ )
            $split_content .= $content[$i] . ' ';
        
        $content = $split_content . '...';
    } else {
        $content = implode( " ", $content );
    }    

    // TAGS UNCLOSED
    $tags = array();
    // get all tags opened
    preg_match_all("/(<([\w]+)[^>]*>)/", $content, $tags_opened, PREG_SET_ORDER);    
    foreach ( $tags_opened as $tag )
        $tags[] = $tag[2];
        
    // get all tags closed and remove it from the tags opened.. the rest will be closed at the end of the content
    preg_match_all("/(<\/([\w]+)[^>]*>)/", $content, $tags_closed, PREG_SET_ORDER);
    foreach ( $tags_closed as $tag )
        unset( $tags[ array_search( $tag[2], $tags ) ] );
    
    // close the tags
    if ( ! empty( $tags ) )
        foreach ( $tags as $tag )
            $content .= "</$tag>";     

    $content = preg_replace( '/\[.+\]/', '', $content );
    $content = preg_replace( '/<img[^>]+./', '', $content ); //remove images
    $content = apply_filters( 'the_content', $content ); 
    $content = str_replace( ']]>', ']]&gt;', $content );  
    
    return $content.$more_text;
}

/**
 * Echo the excerpt with specific number of words
 * 
 * @param int|string $limit
 * @param string $more_text
 * 
 * @return string
 */
function yiw_excerpt( $limit = 25, $more_text = '', $echo = true ) {
    $limit_cb = create_function( '', "return $limit;" );
    $moret_cb = create_function( '', "return '$more_text';" );
    
    add_filter( 'excerpt_length', $limit_cb );   
    add_filter( 'excerpt_more', $moret_cb ); 
    
    if ( $echo )
        the_excerpt();
    else
        return get_the_excerpt();
    
    remove_filter( 'excerpt_length', $limit_cb );   
    remove_filter( 'excerpt_more', $moret_cb ); 
}

/**
 * Get Page ID by page name
 * 
 * @param string $page_name
 * 
 * @return string|int
 */
function yiw_get_pageID_by_pagename( $page_name ) {
    global $wpdb;
    return $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$page_name'");
}    

/**
 * Retrieve the array with all accordion sliders created
 */
function yiw_accordion_sliders( $r = array() ) {
    $post_types = maybe_unserialize( yiw_get_option('accordion_sliders') );
    
    if ( empty( $post_types ) )
        return $r;
		  
  	foreach( $post_types as $post_type )	
  	{
  		$name_post_type = str_replace( ' ', '_', $post_type );  
  	    $r[ $name_post_type ] = $post_type;
	} 
	
	return $r;
} 

function yiw_prettyphoto_style() {
    ?>
    <script type="text/javascript">
        var yiw_prettyphoto_style = '<?php echo yiw_get_option('portfolio_skin_lightbox') ?>';
    </script>
    <?php
}
if ( ! is_admin() ) add_action( 'wp_print_scripts', 'yiw_prettyphoto_style' );


/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since 1.0
 */
function yiw_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    
    if( isset($GLOBALS['count']) ) $GLOBALS['count']++;
    else $GLOBALS['count'] = 1; 
    
    switch ( $comment->comment_type ) :      
        case 'pingback'  :
        case 'trackback' :
    ?>
    <li class="post pingback">
        <p><?php _e( 'Pingback:', 'yiw' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'yiw'), ' ' ); ?></p>
    <?php
            break;
        
        default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-container">
            <div class="comment-author vcard">
                <div class="sphere"><?php echo get_avatar( $comment, 75 ); ?></div>
                <?php printf( __( '%s ', 'yiw' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
            </div><!-- .comment-author .vcard -->
            
            <div class="comment-meta commentmetadata">
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="moderation"><?php _e( 'Your comment is awaiting moderation.', 'yiw' ); ?></em>
                    <br />
                <?php endif; ?>
                
                <div class="intro">
                    <div class="commentDate">
                      <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                        <?php
                            /* translators: 1: date, 2: time */
                            printf( __( '%1$s at %2$s', 'yiw' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'yiw' ), ' ' );
                        ?>
                    </div>

                    <div class="commentNumber">#&nbsp;<?php echo $GLOBALS['count'] ?></div>
                </div>
                    
                <div class="comment-body"><?php comment_text(); ?></div>
                
                
                <div class="reply group">
                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div><!-- .reply -->
            </div><!-- .comment-meta .commentmetadata -->
        </div><!-- #comment-##  -->

    <?php
            break;
    endswitch;
}


// add new option to slider table
function yiw_layout_slide_option( $value, $id, $field ) {
    $v = ( isset( $field['layout_slide'] ) ) ? $field['layout_slide'] : 'center';
    ?>
    <tr>
		<td align="left" colspan="3">
			<label style="color:#333;float:none;display:inline;line-height:1em;">  
				<strong><?php _e('Layout Slide', 'yiw') ?>:</strong>
			</label>
			<em class="small">(<?php _e( 'choose the position of all elements', 'yiw' ) ?>)</em><br>
			<select alt="<?php _e('Layout Slide', 'yiw') ?>" name="<?php yiw_option_name( $value['id'] ); ?>[<?php echo $id ?>][layout_slide]">
			     <option value="left"<?php selected( $v, 'left' ) ?>><?php _e( 'Text Left & Image Right', 'yiw' ) ?></option>
			     <option value="right"<?php selected( $v, 'right' ) ?>><?php _e( 'Text Right & Image Left', 'yiw' ) ?></option>
			     <option value="center"<?php selected( $v, 'center' ) ?>><?php _e( 'Text and Image Center', 'yiw' ) ?></option>
			</select>
		</td>
	</tr>  
    <?php
}
add_action( 'yiw_slider_config_layout', 'yiw_layout_slide_option', 10, 3 );

/**
 * "type" => "sortabled-table"
 */ 
function yiw_sortabled_table( $value ) {
	
	if ( isset( $value['id'] ) )
    		$id_container = 'id="' . $value['id'] . '-option" ';
    		
    	$value_array = yiw_get_option($value['id']); 
    	
    	$current_tab = yiw_get_current_tab();
    	
    	if( $value_array AND !is_array( $value_array ) )
			$value_array = yiw_subval_sort( unserialize( $value_array ), 'order' );
		if( !$value_array )
			$value_array = array();
		
		//echo '<pre>';
		//print_r( yiw_cleanArray($value_array) );
		//echo '</pre>';
		
		if ( count($value_array) < 10 )
		  array_push( $value_array, array() );        
    ?>
    
        <style type="text/css">
            .rm_slides .sortItem .ss-ImageTitle {width:640px;}
        </style>
    
        <div <?php echo $id_container ?>class="rm_option rm_input rm_slides">        
			<ul id="SlideShow">
				
				<?php foreach( $value_array as $id => $field ) : ?>
				<li class="isSortable slide-item noNesting">
					<div class="sortItem">              
						<table width="100%" cellspacing="0" cellpadding="3">
							<tbody>
								<tr>
									<td class="handle">
										<br/>
										&nbsp;<strong><?php _e( 'Order', 'yiw' ) ?>:</strong>
										<input type="text" name="<?php yiw_option_name( $value['id'] ); ?>[<?php echo $id ?>][order]" class="item_order_value" value="<?php echo $id ?>" />
										<div></div>
									</td>
									<td>  
									    <br />
									   
										<strong><?php _e('Title', 'yiw') ?>:</strong><br> 
										<input type="text" value="<?php echo isset( $field['section_title'] ) ? stripslashes( $field['section_title'] ) : '' ?>" alt="<?php _e('Title', 'yiw') ?>" class="ss-ImageTitle" name="<?php yiw_option_name( $value['id'] ); ?>[<?php echo $id ?>][section_title]" />
										
										<br /><br />
                                        
                                        <strong><?php _e('Subtitle', 'yiw') ?>:</strong><br> 
										<textarea rows="2" alt="<?php _e('Subtitle', 'yiw') ?>" class="ss-ImageTitle" name="<?php yiw_option_name( $value['id'] ); ?>[<?php echo $id ?>][section_subtitle]"><?php echo isset( $field['section_subtitle'] ) ? stripslashes( $field['section_subtitle'] ) : '' ?></textarea>
										
										<br /><br />
                                        
                                        <strong><?php _e('Content', 'yiw') ?>:</strong><br> 
										<textarea rows="8" alt="<?php _e('Subtitle', 'yiw') ?>" class="ss-ImageTitle" name="<?php yiw_option_name( $value['id'] ); ?>[<?php echo $id ?>][tooltip_content]"><?php echo isset( $field['tooltip_content'] ) ? stripslashes( $field['tooltip_content'] ) : '' ?></textarea>
										<label style="float:none;"><input type="checkbox" value="1" name="<?php yiw_option_name( $value['id'] ); ?>[<?php echo $id ?>][section_content_autop]"<?php checked( isset( $field['section_content_autop'] ) ? $field['section_content_autop'] : false ) ?> /> <?php _e( 'Add paragraph automatically', 'yiw' ) ?></label>
									    
									    <br /><br />
									    
									    <div class="delete-item"><a class="button-secondary" href="?page=<?php echo $_GET['page'] ?>&tab=<?php echo $current_tab ?>&action=delete&<?php echo $value['id'] ?>=<?php echo $id ?>&key=id"><?php _e('Delete', 'yiw') ?></a></div>
                                    </td>
								</tr>
							</tbody>
						</table>
					</div>
				</li>           
				<?php endforeach ?>
							
			</ul>            
			<p>
				<input class="button-secondary add-slide-button hide-if-no-js" type="button" value="<?php _e( 'Add Section', 'yiw' ) ?>" />
				<input class="button-secondary hide-if-js" type="submit" value="<?php _e( 'Add/Edit Section', 'yiw' ) ?>" />
				<a href="?page=<?php echo $_GET['page'] ?>&tab=<?php echo $current_tab ?>&action=delete&id=<?php echo $value['id'] ?>" class="button-secondary"><?php _e( 'Delete all slides', 'yiw' ) ?></a>
			</p>
    	</div>     
    	
    	<script type="text/javascript">
    		jQuery(document).ready(function($){
				
				$('#<?php echo $value['id'] ?>-option .add-slide-button').click(function(){   
					var empty_slide = $('#SlideShow li:last-child').clone(); 
					var last_index = parseInt( $('#SlideShow li:last-child input[name*="[order]"]').val() );
					//alert(last_index);
					                                        
					if ( $('#SlideShow li').length >= 10 ) {
					   alert("<?php _e( 'Reached the maximum limit of ten sections.', 'yiw' ) ?>");
					   return false;
					}
					
					// empty all inputs
					$('input:not(input[name*="[order]"], input[type="button"], input[type="checkbox"], input[type="radio"]), textarea', empty_slide).val('');
					// change the id of the inputs name
					var pattern_inputs = /\[(\d+)\]/;
					$('input[name*="<?php yiw_option_name( $value['id'] ); ?>"], textarea[name*="<?php yiw_option_name( $value['id'] ); ?>"], select[name*="<?php yiw_option_name( $value['id'] ); ?>"]', empty_slide).each(function(){
						var name = $(this).attr('name');
						var name_match = name.match( pattern_inputs );
						var new_name = name.replace(pattern_inputs, "["+(parseInt(name_match[1])+1)+"]");
						$(this).attr('name', new_name);
					});
					// delete preview image
					$('.ss-ImageSample', empty_slide).attr('src', '');
					
					empty_slide.appendTo('#SlideShow');
					$('#SlideShow li:last-child input[name*="[order]"]').val(last_index+1);
					
					return false;
				});	
			});
    	</script>
         
    <?php
	
}
add_action( 'yiw_panel_type_sortabled-table', 'yiw_sortabled_table' );  



// add new type to theme options
function yiw_select_with_bg_preview( $value ) {
	
	if ( isset( $value['id'] ) )
		$id_container = 'id="' . $value['id'] . '-option" ';            
		
	// deps                   
    if ( isset( $value['deps'] ) ) {
    	$value['deps']['id_input'] = yiw_option_id( $value['deps']['id'], false );
    	$deps[ $value['id'] ] = $value['deps'];
    	$class_dep = ' yiw-deps';
    	$fade_color_dep = '<div class="fade_color"></div>';
    }
    ?>
    
        <div <?php echo $id_container ?>class="rm_option rm_input rm_select<?php echo $class_dep ?> rm_with_preview rm_with_bg_preview">
            <label for="<?php yiw_option_id( $value['id'] ); ?>"><?php echo $value['name']; ?></label>
            
            <select name="<?php yiw_option_name( $value['id'] ); ?>" id="<?php yiw_option_id( $value['id'] ); ?>" <?php if( isset( $value['button'] ) ) : ?>style="width:240px;" <?php endif ?>>
                <?php foreach ($value['options'] as $val => $option) { ?>
                    <option value="<?php echo $val ?>" <?php selected( yiw_get_option( $value['id'], $value['std'] ), $val ) ?>><?php echo $option; ?></option>
                <?php } ?>
            </select>                          
            
			<?php if( isset( $value['button'] ) ) : ?>
			<input type="submit" value="<?php echo $value['button']; ?>" class="button" name="<?php yiw_option_id( $value['id'] ); ?>_save" id="<?php yiw_option_id( $value['id'] ); ?>_save">
			<?php endif ?>
            
            <small><?php echo $value['desc']; ?></small>
            <div class="clearfix"></div>
            
            <?php 
				$url = get_template_directory_uri().'/'.yiw_get_option( $value['id'], $value['std'] );
				$color = yiw_get_option( $value['id_colors'] );
				
				$style = array(
					"background-color:$color;",
					"background-image:url('$url');",
					"background-position:top center;"
				);
				$style = implode( '', $style );
				
				$style_preview = ( yiw_get_option( $value['id'], $value['std'] ) == 'custom' ) ? ' style="display:none"' : '';
			?>
            
            <div class="preview"<?php echo $style_preview ?>><div class="img" style="<?php echo $style ?>"></div></div>
            <script type="text/javascript">
            	jQuery(document).ready(function($){
					var select = $('#<?php yiw_option_id( $value['id'] ); ?>');
					var text_color = $('#<?php yiw_option_id( $value['id_colors'] ); ?>');
					var preview = $('#<?php echo $value['id'] ?>-option .preview');
					
					preview.css('cursor', 'pointer').attr('title', '<?php _e( 'Click here to update the color selected above', 'yiw' ) ?>');
					
					select.change(function(){
						var value = $(this).val();
						if ( value != 'custom' ) {
							$('.img', preview).css({'background-image':'url(<?php echo get_template_directory_uri() . '/'; ?>'+value+')'});
						    preview.show();
						} else {
							preview.hide();	
						}
					});
					
					preview.click(function(){ 
						var value = text_color.val();
						$('.img', preview).css({'background-color':value});
					});
				});
            </script>
        </div>  
         
    <?php		
}
add_action( 'yiw_panel_type_bg_preview', 'yiw_select_with_bg_preview' );

add_filter( 'yiw_tabs_panel', create_function( '$tabs', 'return array();' ) );

/** Tiny Mce Multiple Editor
 * -------------------------------------------------------------------- */
 
/**
 * "type" => "textarea-editor"
 */ 
function yiw_textarea_editors( $value ) {
	
	if (isset($value['id'])){
		
		$id_container = 'id="' . $value['id'] . '-option" ';  
		$id=$value['id'];
		$desc=$value['desc'];
	
		echo"
		<div id=\"$id_container"."-wrapper\" class=\"rm_option rm_input rm_textarea\">
			<label for=\"yiw-theme-options-$id\">Html</label>
			<textarea type=\"textarea\" id=\"$id\" name=\"yiw_theme_options[$id]\"></textarea>
			<small>$desc</small>
			<div class=\"clearfix\"></div>
		</div>
		";
	}
}
add_action( 'yiw_panel_type_textarea-editor', 'yiw_textarea_editors' );  

function multiple_editor($id) { 
	echo"
		<script type=\"text/javascript\">
		/* <![CDATA[ */

		jQuery(document).ready( function () {
			if ( typeof( tinyMCE ) == \"object\" && typeof( tinyMCE.execCommand ) == \"function\" ) {

				tinyMCE.execCommand(\"mceAddControl\", true, \"$id\");

			}
		});

		/* ]]> */
		</script>
	";	
}          
//add_action('admin_head','multiple_editor','99',$id);
?>