<?php

/**
 * Enqueue scripts and styles.
 */
function avenue_scripts() {
    
    wp_enqueue_style( 'avenue-style', get_stylesheet_uri() );
    
    // Get the Options array
    $avenue_options = avenue_get_options();

    // Load Fonts from array
    $fonts = avenue_fonts();
    $non_google_fonts = avenue_non_google_fonts();
    
    // Are both fonts Google Fonts?
    if ( array_key_exists ( $avenue_options['sc_font_family'], $fonts ) && !array_key_exists ( $avenue_options['sc_font_family'], $non_google_fonts ) &&
        array_key_exists ( $avenue_options['sc_font_family_secondary'], $fonts ) && !array_key_exists ( $avenue_options['sc_font_family_secondary'], $non_google_fonts ) ) :
        
        if ( $avenue_options['sc_font_family'] == $avenue_options['sc_font_family_secondary'] ) :
            // Both fonts are Google Fonts and are the same, enqueue once
            wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=' . esc_attr( $fonts[ $avenue_options['sc_font_family'] ] ), array(), AVENUE_VERSION ); 
        else :
            // Both fonts are Google Fonts but are different, enqueue together
            wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=' . esc_attr( $fonts[ $avenue_options['sc_font_family'] ] . '|' . $fonts[ $avenue_options['sc_font_family_secondary'] ] ), array(), AVENUE_VERSION ); 
        endif;
        
    elseif ( array_key_exists ( $avenue_options['sc_font_family'], $fonts ) && !array_key_exists ( $avenue_options['sc_font_family'], $non_google_fonts ) ) :
    
        // Only Primary is a Google Font. Enqueue it.
        wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=' . esc_attr( $fonts[ $avenue_options['sc_font_family'] ] ), array(), AVENUE_VERSION ); 
        
    elseif ( array_key_exists ( $avenue_options['sc_font_family_secondary'], $fonts ) && !array_key_exists ( $avenue_options['sc_font_family_secondary'], $non_google_fonts ) ) :
        
        // Only Secondary is a Google Font. Enqueue it.
        wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=' . esc_attr( $fonts[ $avenue_options['sc_font_family_secondary'] ] ), array(), AVENUE_VERSION ); 
        
    endif;
    
    // Styles
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/inc/css/bootstrap.min.css', array(), AVENUE_VERSION );
    wp_enqueue_style( 'animate', get_template_directory_uri() . '/inc/css/animate.css', array(), AVENUE_VERSION );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/inc/css/font-awesome.min.css', array(), AVENUE_VERSION );
    wp_enqueue_style( 'camera', get_template_directory_uri() . '/inc/css/camera.css', array(), AVENUE_VERSION );
    wp_enqueue_style( 'avenue-old-style', get_template_directory_uri() . '/inc/css/old_avenue.css', array(), AVENUE_VERSION );
    wp_enqueue_style( 'avenue-main-style', get_template_directory_uri() . '/inc/css/avenue.css', array(), AVENUE_VERSION );

    // Scripts
    wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/inc/js/jquery.easing.1.3.js', array('jquery'), AVENUE_VERSION, true );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/inc/js/bootstrap.min.js', array('jquery'), AVENUE_VERSION, true );
    wp_enqueue_script( 'sticky-js', get_template_directory_uri() . '/inc/js/jquery.sticky.js', array('jquery'), AVENUE_VERSION, true );
    wp_enqueue_script( 'bigSlide-js', get_template_directory_uri() . '/inc/js/bigSlide.min.js', array('jquery'), AVENUE_VERSION, true );
    wp_enqueue_script( 'camera-js', get_template_directory_uri() . '/inc/js/camera.min.js', array('jquery'), AVENUE_VERSION, true );
    wp_enqueue_script( 'wow', get_template_directory_uri() . '/inc/js/wow.min.js', array('jquery'), AVENUE_VERSION, true );
    wp_enqueue_script( 'avenue-main-script', get_template_directory_uri() . '/inc/js/avenue.js', array('jquery', 'jquery-masonry'), AVENUE_VERSION, true );

    $slider_array = array(
        'desktop_height'    => isset( $avenue_options['avenue_slider_height'] )     ? $avenue_options['avenue_slider_height']       : '42',
        'slide_timer'       => isset( $avenue_options['avenue_slider_time'] )       ? $avenue_options['avenue_slider_time']         : 4000, 
        'animation'         => isset( $avenue_options['avenue_slider_fx'] )         ? $avenue_options['avenue_slider_fx']           : 'simpleFade',
        'pagination'        => isset( $avenue_options['avenue_slider_pagination'] ) ? $avenue_options['avenue_slider_pagination']   : 'off',
        'navigation'        => isset( $avenue_options['avenue_slider_navigation'] ) ? $avenue_options['avenue_slider_navigation']   : 'on',
        'animation_speed'   => isset( $avenue_options['avenue_slider_trans_time'] ) ? $avenue_options['avenue_slider_trans_time']   : 2000,
        'hover'             => isset( $avenue_options['avenue_slider_hover'] )      ? $avenue_options['avenue_slider_hover']        : 'on',
    );
    
    // Pass each JS object to the custom script using wp_localize_script
    wp_localize_script( 'avenue-main-script', 'avenueSlider', $slider_array );
    
    // Other Scripts
    wp_enqueue_script( 'avenue-navigation', get_template_directory_uri() . '/js/navigation.js', array(), AVENUE_VERSION, true );
    wp_enqueue_script( 'avenue-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), AVENUE_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    
}
add_action( 'wp_enqueue_scripts', 'avenue_scripts' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function avenue_widgets_init() {
    
    $avenue_options = avenue_get_options();
    
    // Homepage A
    register_sidebar(array(
        'name' => __('Homepage Widget Area - A', 'avenue'),
        'id' => 'sidebar-banner',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s animated wow fadeIn">',
        'after_widget' => '</aside>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

    // Homepage B
    register_sidebar(array(
        'name' => __('Homepage Widget Area - B', 'avenue'),
        'id' => 'sidebar-bannerb',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s animated wow fadeIn">',
        'after_widget' => '</aside>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

    // Homepage C
    register_sidebar(array(
        'name' => __('Homepage Widget Area - C', 'avenue'),
        'id' => 'sidebar-bannerc',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s animated wow fadeIn">',
        'after_widget' => '</aside>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

    // Right Sidebar
    register_sidebar(array(
        'name' => __('Sidebar', 'avenue'),
        'id' => 'sidebar-1',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    // Footer
    register_sidebar(array(
        'name' => __('Footer', 'avenue'),
        'id' => 'sidebar-footer',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="' . esc_attr( $avenue_options['sc_footer_columns'] ) . ' widget %2$s animated wow fadeIn">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
}
add_action( 'widgets_init', 'avenue_widgets_init' );

/**
 * Hex to rgb(a) converter function.
 */
function avenue_hex2rgba( $color, $opacity = false ) {

    $default = 'rgb(0,0,0)';

    // Return default if no color provided
    if ( empty( $color ) ) { return $default; }

    // Sanitize $color if "#" is provided
    if ( $color[0] == '#' ) { $color = substr( $color, 1 ); }

    // Check if color has 6 or 3 characters and get values
    if ( strlen( $color ) == 6 ) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }

    // Convert hexadec to rgb
    $rgb =  array_map( 'hexdec', $hex );

    // Check if opacity is set(rgba or rgb)
    if( $opacity ) {

        if( abs( $opacity ) > 1 ) { $opacity = 1.0; }
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';

    } else {

        $output = 'rgb('.implode(",",$rgb).')';

    }

    // Return rgb(a) color string
    return $output;

}

/**
 * Inject dynamic CSS rules with wp_head.
 */
function avenue_custom_css() { 

    $avenue_options = avenue_get_options(); ?>

    <style>

        h1,h2,h3,h4,h5,h6 {
            font-family: <?php echo esc_attr( $avenue_options['sc_font_family'] ); ?>;
            
        }
        
        body {
            font-size: <?php echo esc_attr( $avenue_options['sc_font_size'] ); ?>px;
            font-family: <?php echo esc_attr( $avenue_options['sc_font_family_secondary'] ); ?>;
        }
        
        .error-404 .description {
            font-family: <?php echo esc_attr( $avenue_options['sc_font_family_secondary'] ); ?>;
        }
        
        /*
        ----- Header Heights ---------------------------------------------------------
        */

        @media (min-width:992px) {
            #site-branding,
            #site-navigation {
               height: <?php echo intval( $avenue_options['avenue_branding_bar_height'] ); ?>px !important;
            }
            #site-branding img {
               max-height: <?php echo intval( $avenue_options['avenue_branding_bar_height'] ); ?>px;
            }
            ul#primary-menu > li {
                line-height: <?php echo intval( $avenue_options['avenue_branding_bar_height'] - 5 ); ?>px;
            }
        }

        @media (max-width:991px) {
            header#masthead,
            #site-branding,
            #site-branding-sticky-wrap-sticky-wrapper,
            #site-branding-sticky-wrap-sticky-wrapper #site-branding-sticky-wrap{
               height: <?php echo intval( $avenue_options['avenue_branding_bar_height'] ); ?>px !important;
               min-height: <?php echo intval( $avenue_options['avenue_branding_bar_height'] ); ?>px !important;
            }
        }
        
        #site-branding ul#primary-menu ul.sub-menu {
            top: <?php echo intval( $avenue_options['avenue_branding_bar_height'] ); ?>px;
        }
        
        /* 
        div#content {
            margin-top: <?php echo esc_attr( $avenue_options['avenue_branding_bar_height'] + ( $avenue_options['sc_headerbar_bool'] == 'yes' ? 40 : 0 ) ); ?>px;
        }

        <?php if ( $avenue_options['sc_headerbar_bool'] != 'yes' ) : ?>
        
            div#content {
                margin-top: 80px !important;
            }
            
        <?php endif; ?>
        */
            
        /*
        ----- Theme Colors -----------------------------------------------------
        */
       
        <?php 
        
        $colors_array = avenue_get_theme_skin_colors();
        
        $primary_theme_color = $colors_array['primary'];
        $secondary_theme_color = $colors_array['accent']; 
        
        ?>
       
        /* --- Primary --- */
        
        a, a:visited,
        .primary-color,
        .btn-primary .badge,
        .btn-link,
        .sc-primary-color,
        .icon404,
        header#masthead ul#primary-menu > li > a:hover,
        #site-branding ul#primary-menu ul.sub-menu > li a:hover,
        .scroll-top:hover
        {
            color: <?php echo esc_attr( $primary_theme_color ); ?>;
        }
        
        .btn-primary,
        fieldset[disabled] .btn-primary.active,
        #top-banner,
        #site-toolbar .social-bar a:hover,
        .error-404 i.fa.icon404 
        {
            background: <?php echo esc_attr( $primary_theme_color ); ?>;
        }
        
        .btn-primary,
        .sc-primary-border,
        .scroll-top:hover,
        header#masthead ul#primary-menu > li > a:hover
        {
            border-color: <?php echo esc_attr( $primary_theme_color ); ?>;
        }
        
        .site-branding .search-bar .search-field:focus{
            border-bottom: 1px solid <?php echo esc_attr( $primary_theme_color ); ?>;
        }
        
        .main-navigation .current_page_parent .current-menu-item a,
        .main-navigation .current_page_item > a,
        .main-navigation .current_page_parent > a {
            border-bottom: 5px solid <?php echo esc_attr( $primary_theme_color ); ?>;
        }
        
        .sc-slider-wrapper .camera_caption .secondary-caption {
            background: <?php echo esc_attr( avenue_hex2rgba( $primary_theme_color, .75 ) ); ?>;
        }
        
        @media(max-width: 600px){
            .nav-menu > li.current_page_item a {
                color: <?php echo esc_attr( $primary_theme_color ); ?>;
            }
        }
               
        /* --- Secondary --- */
        
        a:hover,
        .main-navigation .current_page_item a,
        .main-navigation .current-menu-item a
        {
            color: <?php echo esc_attr( $secondary_theme_color ); ?>;
        }
        
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary.active,
        .open .dropdown-toggle.btn-primary
        {
            background-color: <?php echo esc_attr( $secondary_theme_color ); ?>;
        }
        
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary.active,
        .open .dropdown-toggle.btn-primary
        {
            border-color: <?php echo esc_attr( $secondary_theme_color ); ?>;
        }
        
    </style>

<?php }
add_action( 'wp_head', 'avenue_custom_css' );

/**
 * Returns all available fonts as an array
 *
 * @return array of fonts
 */
if( !function_exists( 'avenue_fonts' ) ) {

    function avenue_fonts() {

        $font_family_array = array(
            
            // Web Fonts
            'Arial, Helvetica, sans-serif'                      => 'Arial',
            'Arial Black, Gadget, sans-serif'                   => 'Arial Black',
            'Courier New, monospace'                            => 'Courier New',
            'Georgia, serif'                                    => 'Georgia',
            'Impact, Charcoal, sans-serif'                      => 'Impact',
            'Lucida Console, Monaco, monospace'                 => 'Lucida Console',
            'Lucida Sans Unicode, Lucida Grande, sans-serif'    => 'Lucida Sans Unicode',
            'MS Sans Serif, Tahoma, sans-serif'                 => 'MS Sans Serif',
            'MS Serif, New York, serif'                         => 'MS Serif',
            'Palatino Linotype, Book Antiqua, Palatino, serif'  => 'Palatino Linotype',
            'Tahoma, Geneva, sans-serif'                        => 'Tahoma',
            'Times New Roman, Times, serif'                     => 'Times New Roman',
            'Trebuchet MS, sans-serif'                          => 'Trebuchet MS',
            'Verdana, Geneva, sans-serif'                       => 'Verdana',
            
            // Google Fonts
            'Abel, sans-serif'                                  => 'Abel',
            'Arvo, serif'                                       => 'Arvo:400,400i,700',
            'Bangers, cursive'                                  => 'Bangers',
            'Courgette, cursive'                                => 'Courgette',
            'Domine, serif'                                     => 'Domine',
            'Dosis, sans-serif'                                 => 'Dosis:200,300,400',
            'Droid Sans, sans-serif'                            => 'Droid+Sans:400,700',
            'Economica, sans-serif'                             => 'Economica:400,700',
            'Josefin Sans, sans-serif'                          => 'Josefin+Sans:300,400,600,700',
            'Itim, cursive'                                     => 'Itim',
            'Lato, sans-serif'                                  => 'Lato:100,300,400,700,900,300italic,400italic',
            'Lobster Two, cursive'                              => 'Lobster+Two',
            'Lora, serif'                                       => 'Lora',
            'Lilita One, cursive'                               => 'Lilita+One',
            'Montserrat, sans-serif'                            => 'Montserrat:400,700',
            'Noto Serif, serif'                                 => 'Noto+Serif',
            'Old Standard TT, serif'                            => 'Old+Standard+TT:400,400i,700',
            'Open Sans, sans-serif'                             => 'Open Sans',
            'Open Sans Condensed, sans-serif'                   => 'Open+Sans+Condensed:300,300i,700',
            'Orbitron, sans-serif'                              => 'Orbitron',
            'Oswald, sans-serif'                                => 'Oswald:300,400',
            'Poiret One, cursive'                               => 'Poiret+One',
            'PT Sans Narrow, sans-serif'                        => 'PT+Sans+Narrow',
            'Rajdhani, sans-serif'                              => 'Rajdhani:300,400,500,600',
            'Raleway, sans-serif'                               => 'Raleway:200,300,400,500,700',
            'Roboto, sans-serif'                                => 'Roboto:100,300,400,500',
            'Roboto Condensed, sans-serif'                      => 'Roboto+Condensed:400,300,700',
            'Shadows Into Light, cursive'                       => 'Shadows+Into+Light',
            'Shrikhand, cursive'                                => 'Shrikhand',
            'Source Sans Pro, sans-serif'                       => 'Source+Sans+Pro:200,400,600',
            'Teko, sans-serif'                                  => 'Teko:300,400,600',
            'Titillium Web, sans-serif'                         => 'Titillium+Web:400,200,300,600,700,200italic,300italic,400italic,600italic,700italic',
            'Trirong, serif'                                    => 'Trirong:400,700',
            'Ubuntu, sans-serif'                                => 'Ubuntu',
            'Vollkorn, serif'                                   => 'Vollkorn:400,400i,700',
            'Voltaire, sans-serif'                              => 'Voltaire',
            
        );

        return apply_filters( 'avenue_fonts', $font_family_array );

    }

}

/**
 * Retrieve non-Google based fonts.
 */
function avenue_non_google_fonts() {
    
    return array(
            
        // Web Fonts
        'Arial, Helvetica, sans-serif'                      => 'Arial',
        'Arial Black, Gadget, sans-serif'                   => 'Arial Black',
        'Courier New, monospace'                            => 'Courier New',
        'Georgia, serif'                                    => 'Georgia',
        'Impact, Charcoal, sans-serif'                      => 'Impact',
        'Lucida Console, Monaco, monospace'                 => 'Lucida Console',
        'Lucida Sans Unicode, Lucida Grande, sans-serif'    => 'Lucida Sans Unicode',
        'MS Sans Serif, Tahoma, sans-serif'                 => 'MS Sans Serif',
        'MS Serif, New York, serif'                         => 'MS Serif',
        'Palatino Linotype, Book Antiqua, Palatino, serif'  => 'Palatino Linotype',
        'Tahoma, Geneva, sans-serif'                        => 'Tahoma',
        'Times New Roman, Times, serif'                     => 'Times New Roman',
        'Trebuchet MS, sans-serif'                          => 'Trebuchet MS',
        'Verdana, Geneva, sans-serif'                       => 'Verdana',

    );
    
}

/**
 * Render the toolbar in the header.
 */
add_action( 'avenue_toolbar', 'avenue_render_toolbar' );
function avenue_render_toolbar() {
    
    get_template_part('template-parts/layout', 'toolbar' );
    
}

/**
 * Render the slider on the frontpage.
 */
add_action( 'avenue_slider', 'avenue_render_slider', 10 );
function avenue_render_slider() {
    
    get_template_part('template-parts/layout', 'slider' );
    
}

/**
 * Render the CTA Trio on the frontpage.
 */
add_action( 'avenue_cta_trio', 'avenue_render_cta_trio' );
function avenue_render_cta_trio() {

    get_template_part('template-parts/layout', 'cta-trio' );

}

/**
 * Render the footer.
 */
add_action( 'avenue_footer', 'avenue_render_footer' );
function avenue_render_footer() {
    
    get_template_part('template-parts/layout', 'footer' );
    
}

/**
 * Render the free Widget Areas.
 */
add_action( 'avenue_free_widget_areas', 'avenue_render_free_widget_areas' );
function avenue_render_free_widget_areas() {
    
    get_template_part('template-parts/layout', 'homepage-areas' );
    
}

/**
 * Render the SC designer section.
 */
add_action( 'avenue_designer', 'avenue_add_designer', 10 );
function avenue_add_designer() { ?>
    
    <a href="https://smartcatdesign.net/" rel="designer" style="display: inline-block !important" class="rel">
        <?php printf( esc_html__( 'Designed by %s', 'avenue' ), 'Smartcat' ); ?> 
        <img id="scl" src="<?php echo get_template_directory_uri() . '/inc/images/cat_logo_mini.png'?>" alt="<?php printf( esc_attr__( '%s Logo', 'avenue'), 'Smartcat' ); ?>" />
    </a>
    
<?php }

/**
 * 
 * Get an array containing the primary and accent colors in use by the theme.
 * 
 * @return String Array
 */
function avenue_get_theme_skin_colors() {
    
    $avenue_options = avenue_get_options();
    
    $colors_array = array();
    
    if ( isset( $avenue_options['avenue_use_custom_colors'] ) && $avenue_options['avenue_use_custom_colors'] == 'custom' ) :
        
        $colors_array['primary'] = isset( $avenue_options['avenue_custom_primary'] ) ? $avenue_options['avenue_custom_primary'] : '#83CBDC';
        $colors_array['accent'] = isset( $avenue_options['avenue_custom_accent'] ) ? $avenue_options['avenue_custom_accent'] : '#57A9BD';

    else :

        switch ( $avenue_options['sc_theme_color'] ) :

            case 'orange' :
                $colors_array['primary'] = '#FF6131';
                $colors_array['accent'] = '#D85904';
                break;

            case 'green' :
                $colors_array['primary'] = '#0FAF97';
                $colors_array['accent'] = '#0B9681';
                break;

            case 'blue' :
                $colors_array['primary'] = '#3B7DBD';
                $colors_array['accent'] = '#195794';
                break;

            default :
                $colors_array['primary'] = '#FF6131';
                $colors_array['accent'] = '#D85904';
                break;

        endswitch;

    endif;
    
    return $colors_array;

}

add_filter( 'avenue_capacity', 'avenue_check_capacity', 10, 1 );
function avenue_check_capacity( $base_value = 1 ) {
    
    if ( function_exists( 'avenue_strap_pl' ) && avenue_strap_pl() ) :
        return $base_value + 6;
    else:
        return $base_value + 3;
    endif;
    
}