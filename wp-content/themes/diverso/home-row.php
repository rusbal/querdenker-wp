    <div class="home-row gradient group">
    
        <div class="top shadow"></div>  
    
        <?php get_template_part( 'slogan' ); ?>
        
        <div class="post-sidebar group">
            <?php 
                if ( ! dynamic_sidebar( 'Home Row' ) ) :
                    
                    $icon_widget = new icon_text();
                    
                    $args = array(
                        'before_widget' => '<div class="one-third icon-text">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3>',
                        'after_title' => '</h3>'
                    );
                    
                    $icon_widget->widget( $args, array(
                        'title' => 'Widget 1',
                        'icon_img' => 'call',
                        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel dui ut augue tempus condimentum. Etiam rhoncus elementum In erat risus, pulvinar ac pulvinar adipiscing.'
                    ) );
                    
                    $icon_widget->widget( $args, array(
                        'title' => 'Widget 2',
                        'icon_img' => 'email',
                        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel dui ut augue tempus condimentum. Etiam rhoncus elementum In erat risus, pulvinar ac pulvinar adipiscing.'
                    ) );
                    
                    $args['before_widget'] = '<div class="one-third last icon-text">';
                    
                    $icon_widget->widget( $args, array(
                        'title' => 'Widget 2',
                        'icon_img' => 'smile',
                        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel dui ut augue tempus condimentum. Etiam rhoncus elementum In erat risus, pulvinar ac pulvinar adipiscing.'
                    ) );
                        
                endif;
            ?>
        </div>
    
    </div> 