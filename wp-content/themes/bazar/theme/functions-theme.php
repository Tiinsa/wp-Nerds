<?php
/**
 * Your Inspiration Themes
 * 
 * @package WordPress
 * @subpackage Your Inspiration Themes
 * @author Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
 
/**
 * Theme setup file
 */

/**
 * Set up all theme data.
 * 
 * @return void
 * @since 1.0.0
 */
function yit_setup_theme() {    
    //Content width. WP require it. So give to WordPress what is of WordPress
    if( !isset( $content_width ) ) { $content_width = yit_get_option( 'container-width' ); }
    
    //This theme have a CSS file for the editor TinyMCE
    add_editor_style( 'css/editor-style.css' );
    
    //This theme support post thumbnails
    add_theme_support( 'post-thumbnails' );
    
    //This theme uses the menues
    add_theme_support( 'menus' );
    
    //Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );
    
    //This theme support post formats
    add_theme_support( 'post-formats', apply_filters( 'yit_post_formats_support', array( 'gallery', 'audio', 'video', 'quote' ) ) );    
    
    if ( ! defined( 'HEADER_TEXTCOLOR' ) )
        define( 'HEADER_TEXTCOLOR', '' );

    // The height and width of your custom header. You can hook into the theme's own filters to change these values.
    // Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
    define( 'HEADER_IMAGE_WIDTH', apply_filters( 'yiw_header_image_width', 1170 ) );
    define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'yiw_header_image_height', 410 ) );     
    
    // Don't support text inside the header image.
    if ( ! defined( 'NO_HEADER_TEXT' ) )
        define( 'NO_HEADER_TEXT', true );
    
    //This theme support custom header
    add_theme_support( 'custom-header' );
    
    //This theme support custom backgrounds
    add_theme_support( 'custom-backgrounds' );
    
    // We'll be using post thumbnails for custom header images on posts and pages.
    // We want them to be 940 pixels wide by 198 pixels tall.
    // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
    // set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );    
    $image_sizes = array(
        'blog_big'     => array( 890, 0, true ),
        'blog_small'   => array( 365, 320, true ),
        'blog_elegant' => array( 539, 0, true ),
        'blog_big_ribbon' => array( 760, 0, true ),
        'blog_small_ribbon' => array( 370, 320, true ),
        'blog_sphera'   => array( 280, 305, true ),
        'blog_bazar'   => array( 858, 338, true ),
        'blog_thumb'   => array( 75, 75, true ),
        'section_blog' => array( 263, 243, true ),
        'section_services' => array( 175, 175, true ),
        'thumb-testimonial' => array( 41, 41, true ),
        'thumb-testimonial-circle' => array( 100, 100, true ),
        'thumb-testimonial-quote' => array( 87, 85, true ),
        'thumb-testimonial-square' => array( 116, 116, true ),
        'thumb-testimonial-bazar' => array( 62, 62, true ),
        'thumb_portfolio_fulldesc_related' => array( 258, 170, true ),
        'thumb_portfolio_bigimage' => array( 656, 0 ),
        'thumb_portfolio_filterable' => array( 260, 168, true ),
        'thumb_portfolio_fulldesc' => array( 574, 340, true ),
        'thumb_portfolio_fulldesc_big' => array( 1158, 400, true ),
        'section_video' => array( 162, 136, true ),
        'section_portfolio' => array( 660, 360, true ),
        'section_portfolio_sidebar' => array( 385, 192, true ),
        'section_portfolio_thumb' => array( 164, 106, true ),
        'thumb_portfolio_2cols' => array( 560, 324, true ),
        'thumb_portfolio_3cols' => array( 360, 216, true ),
        'thumb_portfolio_4cols' => array( 260, 172, true ),
        'accordion_thumb' => array( 266, 266, true ),
        'team_rounded_thumb' => array( 130, 130, true ),
        'team_professional_thumb' => array( 270, 270, true ),
        'team_professional_mini_thumb' => array( 70, 70, true ),
        'featured_project_thumb' => array( 320, 154, true ),
        'thumb_portfolio_slide' => array( 560, 377, true ),
        'thumb_portfolio_pinterest' => array( 260, 0 ),
        'nav_menu' => array( 170, 0 ),
    );
    
    $image_sizes = apply_filters( 'yit_add_image_size', $image_sizes );
    
    foreach ( $image_sizes as $id_size => $size )               
        yit_add_image_size( $id_size, apply_filters( 'yit_' . $id_size . '_width', $size[0] ), apply_filters( 'yit_' . $id_size . '_height', $size[1] ), isset( $size[2] ) ? $size[2] : false );
    
    //Register theme default header. Usually one
//     register_default_headers( array(
//         'theme_header' => array(
//             'url' => '%s/images/headers/001.jpg',
//             'thumbnail_url' => '%s/images/headers/thumb/001.jpg',
//             /* translators: header image description */
//             'description' => __( 'Design', 'yit' ) . ' 1'
//         )
//     ) );
    
    //Set localization and load language file
    $locale = get_locale();
    $locale_file = YIT_THEME_PATH . "/languages/$locale.php";
    if ( is_readable( $locale_file ) )
        require_once( $locale_file );
    
    //Register menus
    register_nav_menus(
        array(
            'nav' => __( 'Main navigation', 'yit' ),
            //'top' => __( 'Top Bar', 'yit' )
        )
    );
    
    //Register sidebars
    register_sidebar( yit_sidebar_args( 'Default Sidebar' ) );
	register_sidebar( yit_sidebar_args( 'Home Sidebar', 'Widget area for Home Page Template', 'home-widget span3' ) );
    register_sidebar( yit_sidebar_args( 'Blog Sidebar' ) );
    register_sidebar( yit_sidebar_args( '404 Sidebar' ) );
    register_sidebar( yit_sidebar_args( 'Header Sidebar', 'Widget area for Header', 'widget' ) );
    register_sidebar( yit_sidebar_args( 'Topbar Left', 'Left widget area for Tob Bar' ) );
    register_sidebar( yit_sidebar_args( 'Topbar Right', 'Right widget area for Tob Bar' ) );
	
    //User defined sidebars
    do_action( 'yit_register_sidebars' );
    
    //Register custom sidebars
    $sidebars = maybe_unserialize( yit_get_option( 'custom-sidebars' ) );
    if( is_array( $sidebars ) && ! empty( $sidebars ) ) {
        foreach( $sidebars as $sidebar ) {
            register_sidebar( yit_sidebar_args( $sidebar, '', 'widget', apply_filters( 'yit_custom_sidebar_title_wrap', 'h3' ) ) );
        }
    }
    
    //Footer with sidebar type widgets
    if( strstr( yit_get_option( 'footer-type' ), 'sidebar' ) ) {
        register_sidebar( yit_sidebar_args( "Footer Widgets Area", __( "The widget area used in Footer With Sidebar section", 'yit' ), 'widget span2', apply_filters( 'yit_footer_widget_area_wrap', 'h3' ) ) );
        register_sidebar( yit_sidebar_args( "Footer Sidebar", __( "The sidebar used in Footer With Sidebar section", 'yit' ), 'widget span6', apply_filters( 'yit_footer_widget_area_wrap', 'h3' ) ) );
    } //else {
        //Footer sidebars
        for( $i = 1; $i <= yit_get_option( 'footer-rows', 0 ); $i++ ) {
            register_sidebar( yit_sidebar_args( "Footer Row $i", sprintf(  __( "The widget area #%d used in Footer section", 'yit' ), $i ), 'widget span' . ( 12 / yit_get_option( 'footer-columns' ) ), apply_filters( 'yit_footer_sidebar_' . $i . '_wrap', 'h3' ) ) );
        }
    //}
}

function yit_include_woocommerce_functions() {
    if ( ! is_shop_installed() ) return;  
    
    include_once 'woocommerce.php';
}
add_action( 'yit_loaded', 'yit_include_woocommerce_functions' );


wp_oembed_add_provider( '#https?://(?:api\.)?soundcloud\.com/.*#i', 'http://soundcloud.com/oembed', true );   

function yit_meta_like_body( $css ) {
    $body_bg = yit_get_option( 'background-style' );
    
    return $css . '.blog-big .meta, .blog-small .meta { background: ' . $body_bg['color'] . '; }';
}

/**
 * Remove Items option from the magnifier
 * 
 * @param array $array
 * @return array
 * @since 1.0
 */
function yit_remove_items_options_yith_wcmg( $array ) {
    foreach( $array['slider'] as $key => $option ) {
        if( $option['id'] == 'yith_wcmg_slider_items' ) {
            unset( $array['slider'][$key] );
        }
    }
    
    return $array;
}

/**
 * Remove Add to wishlist text option
 * 
 */
function yit_remove_wishlist_text_option( $options ) {
    if( isset( $options['general_settings'][7] ) && $options['general_settings'][7]['id'] == 'yith_wcwl_add_to_wishlist_text' )
        { unset( $options['general_settings'][7] ); }
    
    return $options;
}

/**
 * Add the style for variations dropdowns scrollable.
 */
function yit_scrollable_variations() {
    if( is_shop_installed() && !is_product() ) { return; }

    if( yit_get_option( 'shop-variations-scrollable' ) ) : ?>
    <style>
        .variations .select-wrapper .sbOptions { max-height: <?php echo yit_get_option( 'shop-variations-scrollable-height' ) ?>px !important; overflow: scroll; }
    </style>
    <?php
    endif;
}