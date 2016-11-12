       				<?php $has_thumbnail = ( is_search() || ! has_post_thumbnail() || ( ! is_single() && ! yiw_get_option( 'show_featured_blog', 1 ) ) || ( is_single() && ! yiw_get_option( 'show_featured_single', 1 ) ) ) ? false : true; ?>
                       
                    <div id="post-<?php the_ID(); ?>" <?php post_class('hentry-post group blog-big' ); ?>>                
                              
                        <div class="<?php if ( ! $has_thumbnail ) echo 'without ' ?>thumbnail">
                            <?php if ( $has_thumbnail ) the_post_thumbnail( 'blog_big' ); ?>   
                            
                            <p class="date">
                                <span class="month"><?php echo get_the_time('M') ?></span>
                                <span class="day"><?php echo get_the_time('d') ?></span>
                            </p>
                            
                            <?php 
                                $link = get_permalink();
                                if ( is_single() )  the_title( "<h1><a href=\"$link\">", "</a></h1>" ); 
                                else                the_title( "<h2><a href=\"$link\">", "</a></h2>" ); 
                                
                                if ( get_post_type() == 'bl_gallery' )
                                    $tax = 'category-photo';
                                else   
                                    $tax = 'category';
                            ?>
                        </div>
                        <?php if ( ! is_search() ) : ?>
                        <div class="meta group">
                            <p class="author"><span><?php _e( 'by', 'yiw' ) ?> <?php the_author_posts_link() ?></span></p>
                            <p class="categories"><span>In: <?php echo get_the_term_list( get_the_ID(), $tax, '', ', ', '' ); ?></span></p>
                            <p class="comments"><span><?php comments_popup_link(__('No comments', 'yiw'), __('1 comment', 'yiw'), __('% comments', 'yiw')); ?></span></p>
                        </div>
                        <?php endif; ?>
                        
                        <div class="the-content"><?php 
                            $read_more = create_function( '$more', 'return "<br /><br /><a class=\"more-link\" href=\"'. get_permalink( get_the_ID() ) . '\">' . yiw_get_option('blog_read_more_text') . '</a>";' );
                            add_filter( 'excerpt_more', $read_more );
                            the_content( yiw_get_option('blog_read_more_text') ); 
                            remove_filter( 'excerpt_more', $read_more );
                        ?></div>
                        
                        <?php wp_link_pages(); ?>
                        
						<?php edit_post_link( __( 'Edit', 'yiw' ), '<span class="edit-link">', '</span>' ); ?>
					
						<?php if( is_single() ) the_tags( '<p class="list-tags">Tags: ', ', ', '</p>' ) ?>    
                    
                    </div>         