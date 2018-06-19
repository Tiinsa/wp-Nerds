<?php 
/**
 * All functions and hooks for woocommerce plugin  
 *
 * @package WordPress
 * @subpackage YIThemes
 */          

global $woocommerce;

// global flag to know that woocommerce is active
$yiw_is_woocommerce = true; 

/* === GENERAL SETTINGS === */
add_theme_support('woocommerce');
register_sidebar( yit_sidebar_args( 'Shop Sidebar' ) );


/* === HOOKS === */                                                     
add_action( 'wp_enqueue_scripts', 'yit_enqueue_woocommerce_assets' ); 
add_action( 'woocommerce_before_main_content', 'yit_shop_page_meta' );                                   
add_action( 'shop_page_meta'     , 'yit_woocommerce_list_or_grid' );
if ( yit_get_option( 'shop-show-breadcrumb' ) ) add_action( 'shop_page_meta', 'woocommerce_breadcrumb' );
add_action( 'shop_page_meta'     , 'yit_woocommerce_catalog_ordering' );  
add_filter( 'woocommerce_page_settings', 'yit_woocommerce_deactive_logout_link' ); 
add_action( 'wp_head', 'yit_size_images_style' ); 
add_filter( 'loop_shop_per_page' , 'yit_set_posts_per_page');
add_filter( 'woocommerce_catalog_settings', 'yit_add_featured_products_slider_image_size' );
//add_filter( 'woocommerce_catalog_settings', 'yit_add_responsive_image_option' );
add_filter( 'yith_wcwl_button_label', 'yit_change_wishlist_label' );
add_filter( 'yith-wcwl-browse-wishlist-label', 'yit_change_browse_wishlist_label' );
add_action( 'get_footer', 'yit_woocp_footer_script', 20 );
add_action( 'yit_activated', 'yit_woocommerce_default_image_dimensions');
add_action( 'admin_init', 'yit_woocommerce_update' ); //update image names after woocommerce update

add_filter( 'yit_sample_data_tables',  'yit_save_woocommerce_tables' );
add_filter( 'yit_sample_data_options', 'yit_save_woocommerce_options' );
add_filter( 'yit_sample_data_options', 'yit_save_wishlist_options' );


/* shop */  
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_main_content' , 'woocommerce_breadcrumb', 20, 0 );  
remove_action( 'woocommerce_pagination'          , 'woocommerce_catalog_ordering', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_filter( 'woocommerce_star_rating_size', 'yit_product_rate_size' );
add_filter( 'woocommerce_star_rating_size_shop_loop', 'yit_product_rate_size' );  
add_filter( 'woocommerce_star_rating_size_sidebar', 'yit_product_rate_size' );  
add_filter( 'woocommerce_star_rating_size_size_recent_reviews', 'yit_product_rate_size' );
add_action( 'woocommerce_before_shop_loop_item_title', 'yit_woocommerce_out_of_stock_flash' );  
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/* single */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
if ( yit_get_option('shop-detail-show-price') )  add_action( 'yit_product_box', 'woocommerce_template_single_price', 10 );
if ( yit_get_option('shop-detail-add-to-cart') ) add_action( 'yit_product_box', 'woocommerce_template_single_add_to_cart', 20 );
// move product tabs and related products under sidebar
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_sidebar', 'woocommerce_output_product_data_tabs', 20 );
add_action( 'woocommerce_after_sidebar', 'woocommerce_upsell_display', 25 );
add_action( 'woocommerce_after_sidebar', 'woocommerce_output_related_products', 30 );
if ( yit_get_option('shop-show-related') ) {
	add_action( 'woocommerce_related_products_args', 'yit_related_posts_per_page' );
}
function yit_related_posts_per_page() {
	global $product;
	$related = $product->get_related(yit_get_option('shop-number-related'));
	return array( 
		'posts_per_page' 		=> yit_get_option('shop-number-related'),
		'post_type'				=> 'product',
		'ignore_sticky_posts'	=> 1,
		'no_found_rows' 		=> 1,
		'post__in' 				=> $related
	);
}
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 30 );

if( !yit_get_option( 'shop-show-metas') ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
}

/* tabs */                                                                     
add_action( 'woocommerce_product_tabs', 'yit_woocommerce_add_tabs' );  // Woo 2
//add_action( 'woocommerce_product_tabs', 'yit_woocommerce_add_info_tab', 40 );
add_action( 'woocommerce_product_tab_panels', 'yit_woocommerce_add_info_panel', 40 );
//add_action( 'woocommerce_product_tabs', 'yit_woocommerce_add_custom_tab', 50 );
add_action( 'woocommerce_product_tab_panels', 'yit_woocommerce_add_custom_panel', 50 );

/* admin */
add_action( 'woocommerce_product_options_general_product_data', 'yit_woocommerce_admin_product_ribbon_onsale' );
add_action( 'woocommerce_process_product_meta', 'yit_woocommerce_process_product_meta',2,2 );


//if ( yit_get_option( 'shop-show-breadcrumb' ) ) add_action( 'shop_page_meta', 'woocommerce_breadcrumb' );

// active the price filter
if( version_compare($woocommerce->version,"2.0.0",'<') ) {
    add_action('init', 'woocommerce_price_filter_init');
}

add_filter('loop_shop_post_in', 'woocommerce_price_filter'); 


/* === FUNCTIONS === */
function yit_enqueue_woocommerce_assets() {
    wp_enqueue_script( 'yit-woocommerce', YIT_THEME_ASSETS_URL . '/js/woocommerce.js', array( 'jquery', 'jquery-cookie' ), '1.0', true );
}

function yit_woocommerce_catalog_ordering() {
    if ( ! is_single() ) woocommerce_catalog_ordering();    
}         

function yit_set_posts_per_page( $cols ) {        
    $items = yit_get_option( 'shop-products-per-page', $cols );         
    return $items == 0 ? -1 : $items;
}                             

function yit_woocommerce_list_or_grid() {
    woocommerce_get_template( 'shop/list-or-grid.php' );
}                            

function yit_woocommerce_added_button() {
    woocommerce_get_template( 'loop/added.php' );
}   

function yit_shop_page_meta() {
    woocommerce_get_template( 'shop/page-meta.php' );
}


function yit_woocommerce_show_product_thumbnails() {
	woocommerce_get_template( 'single-product/thumbs.php' );
}

/* Woo >= 2 */
function yit_woocommerce_add_tabs( $tabs ) {
    global $post;
    
    if ( yit_get_post_meta( $post->ID, '_use_ask_info' ) ) {
    	$tabs['info'] = array(
    		'title'    => apply_filters( 'yit_ask_info_label', __('Product Enquiry', 'yit') ),
    		'priority' => 30,
    		'callback' => 'yit_woocommerce_add_info_panel'
    	);
    }
	
	$custom_tabs = yit_get_post_meta($post->ID, '_custom_tabs');
	if( !empty( $custom_tabs ) ) {
        foreach( $custom_tabs as $tab ) {
        	$tabs['custom'.$tab["position"]] = array(
        		'title'    => $tab["name"],
        		'priority' => 30,
        		'callback' => 'yit_woocommerce_add_custom_panel',
        		'custom_tab' => $tab
        	);
        }
    }
	
	return $tabs;
}
                               
/* custom and info tabs Woo 2 < */
function yit_woocommerce_add_info_tab() {
	woocommerce_get_template( 'single-product/tabs/tab-info.php' );
}

function yit_woocommerce_add_info_panel() {
	woocommerce_get_template( 'single-product/tabs/info.php' );
}
        
function yit_woocommerce_add_custom_tab() {
	woocommerce_get_template( 'single-product/tabs/tab-custom.php' );
}

function yit_woocommerce_add_custom_panel( $key, $tab ) {
 woocommerce_get_template( 'single-product/tabs/custom.php', array( 'key' => $key, 'tab' => $tab ) );
}

function woocommerce_template_loop_product_thumbnail() {
	echo '<a href="' . get_permalink() . '" class="thumb">' . woocommerce_get_product_thumbnail() . '</a>';
}

function yit_product_single_boxmeta() {
	woocommerce_get_template( 'single-product/box-meta.php' );
}

function yit_product_rate_size() {
	return 13;
}

function yit_woocommerce_sharethis() {
    if ( is_product() ) return;
    do_action('woocommerce_share');
}

function yit_woocommerce_out_of_stock_flash() {
    global $product;
    
    if ( ! $product->is_in_stock() ) echo '<span class="out-of-stock" style="display: inline;">out of stock</span>';
}

function yit_add_sharethis_button_js() {
    global $woocommerce, $product, $post, $yit_sharethis;
    
    if ( ! isset( $woocommerce->integrations->integrations['sharethis'] ) || 
         empty( $woocommerce->integrations->integrations['sharethis']->publisher_id ) ||  
         ( ! yit_get_option('shop-view-show-share') && ! is_product() ) ||
         ( yit_get_option( 'shop-layout', 'with-hover' ) == 'classic' && is_product() )
       ) return;
                                                                                                                                                                                                               
	if ( !is_product() && ! isset( $yit_sharethis ) ) {
        $sharethis = ( is_ssl() ) ? 'https://ws.sharethis.com/button/buttons.js' : 'http://w.sharethis.com/button/buttons.js';
        echo '<script type="text/javascript">var switchTo5x=true;</script><script type="text/javascript" src="' . $sharethis . '"></script>';
		echo '<script type="text/javascript">stLight.options({publisher:"' . $woocommerce->integrations->integrations['sharethis']->publisher_id . '" });</script>';
    }
    
    printf('<script type="text/javascript">
    stLight.options({
            onhover:false
    });
    stWidget.addEntry({
        	"service" : "sharethis",
        	"element" : document.getElementById("%s"),
        	"url"     : "%s",
        	"title"   : "%s",
        	"type"    : "large",
        	"text"    : "%s",
        	"image"   : "%s",
        	"summary" : "%s"   
        }, {button:true});
    </script>', "share_$product->id", get_permalink($product->id), get_the_title(), get_the_title(), yit_image( "output=url", false ), str_replace( array( "\r", "\n" ), ' ', esc_attr( strip_tags( $post->post_content ) ) ) );
    
    $yit_sharethis = true;
}

/* share */
function yit_woocommerce_share() {
    if( !yit_get_option( 'shop-share' ) )
        { return; }
    
	echo do_shortcode('[share class="product-share" title="' . yit_get_option( 'shop-share-title' ) . '" socials="' . yit_get_option( 'shop-share-socials' ) . '"]');
}

/* logout link */
function yit_woocommerce_deactive_logout_link( $options ) {
    foreach ( $options as $option ) {
        if ( isset( $option['id'] ) && $option['id'] != 'yit_woocommerce_deactive_logout_link' ) continue;
        
        $option['std'] = 'no';
        break;
    }
    
    return $options;
}

/* checkout */
add_filter('wp_redirect', 'yit_woocommerce_checkout_registration_redirect'); 
function yit_woocommerce_checkout_registration_redirect( $location ) {
	if ( isset($_POST['register']) && $_POST['register'] && isset($_POST['yit_checkout']) && $location == get_permalink(woocommerce_get_page_id('myaccount')) ) {
		$location = get_permalink(woocommerce_get_page_id('checkout'));
	}
	
	return $location;
}           

function yit_change_wishlist_label() {
    return __( 'Wishlist', 'yit' );
}    

function yit_change_browse_wishlist_label() {
    return __( 'View Wishlist', 'yit' );
}



/* admin */
function yit_woocommerce_admin_product_ribbon_onsale() {
	woocommerce_get_template( 'admin/custom-onsale.php' );
}
function yit_woocommerce_process_product_meta( $post_id, $post ) {
    
    $active = (isset($_POST['_active_custom_onsale'])) ? 'yes' : 'no';
    update_post_meta( $post_id, '_active_custom_onsale', esc_attr( $active ) );
    
    if (isset($_POST['_preset_onsale_icon'])) update_post_meta( $post_id, '_preset_onsale_icon', esc_attr( $_POST['_preset_onsale_icon'] ) );
    if (isset($_POST['_custom_onsale_icon'])) update_post_meta( $post_id, '_custom_onsale_icon', esc_attr( $_POST['_custom_onsale_icon'] ) );    
}         

        
/**
 * SIZES
 */ 

// shop small
function yit_shop_small_w() { global $woocommerce; $size = $woocommerce->get_image_size('shop_catalog'); return $size['width']; }	
function yit_shop_small_h() { global $woocommerce; $size =$woocommerce->get_image_size('shop_catalog'); return $size['height']; }   
// shop thumbnail
function yit_shop_thumbnail_w() { global $woocommerce; $size = $woocommerce->get_image_size('shop_thumbnail'); return $size['width']; }	
function yit_shop_thumbnail_h() { global $woocommerce; $size = $woocommerce->get_image_size('shop_thumbnail'); return $size['height']; } 
// shop large
function yit_shop_large_w() { global $woocommerce; $size = $woocommerce->get_image_size('shop_single'); return $size['width']; }	
function yit_shop_large_h() { global $woocommerce; $size = $woocommerce->get_image_size('shop_single'); return $size['height']; } 

// print style for small thumb size
function yit_size_images_style() {
    $content_width = yit_get_sidebar_layout() == 'sidebar-no' ? 1170 : 870;
	?>
	<style type="text/css">
	ul.products li.product.list {padding-left:<?php echo yit_shop_small_w() + 30 + 7 + 2; ?>px}
	ul.products li.product.list .product-thumbnail {margin-left:-<?php echo yit_shop_small_w() + 30 + 7 + 2; ?>px}
    .widget.widget_onsale li,
    .widget.widget_best_sellers li,
    .widget.widget_recent_reviews li,
    .widget.widget_recent_products li,
    .widget.widget_random_products li,
    .widget.widget_featured_products li,
    .widget.widget_top_rated_products li,
    .widget.widget_recently_viewed_products li {min-height: <?php echo yit_shop_thumbnail_h() ?>px}

    .widget.widget_onsale li .star-rating,
    .widget.widget_best_sellers li .star-rating,
    .widget.widget_recent_reviews li .star-rating,
    .widget.widget_recent_products li .star-rating,
    .widget.widget_random_products li .star-rating,
    .widget.widget_featured_products li .star-rating,
    .widget.widget_top_rated_products li .star-rating,
    .widget.widget_recently_viewed_products li .star-rating { margin-left: <?php echo yit_shop_thumbnail_w() + 15 ?>px}

    /* IE8, Portrait tablet to landscape and desktop till 1024px */
    .single-product div.images { width:<?php echo ( yit_shop_large_w() - 20 ) / 870 * 100 ?>%; }
    .single-product div.summary { width:<?php echo 96 - ( ( yit_shop_large_w() + 2 ) / 870 * 100 ) ?>%; }

    /* WooCommerce standard images */
    .single-product .images .thumbnails > a { width:<?php echo min( yit_shop_thumbnail_w(), 80 ) ?>px !important; height:<?php echo min( yit_shop_thumbnail_h(), 80 ) ?>px !important; }
    /* Slider images */
    .single-product .images .thumbnails li img { max-width:<?php echo min( yit_shop_thumbnail_w(), 80 ) ?>px !important; }

    /* Desktop above 1200px */
    @media (min-width:1200px) {
        /* WooCommerce standard images */
        .single-product .images .thumbnails > a { width:<?php echo min( yit_shop_thumbnail_w(), 100 ) ?>px !important; height:<?php echo min( yit_shop_thumbnail_h(), 100 ) ?>px !important; }
        /* Slider images */
        .single-product .images .thumbnails li img { max-width:<?php echo min( yit_shop_thumbnail_w(), 100 ) ?>px !important; }
    }

    /* Desktop above 1200px */
    @media (max-width: 979px) and (min-width: 768px) {
        /* WooCommerce standard images */
        .single-product .images .thumbnails > a { width:<?php echo min( yit_shop_thumbnail_w(), 63 ) ?>px !important; height:<?php echo min( yit_shop_thumbnail_h(), 63 ) ?>px !important; }
        /* Slider images */
        .single-product .images .thumbnails li img { max-width:<?php echo min( yit_shop_thumbnail_w(), 63 ) ?>px !important; }
    }

    <?php if( yit_get_option( 'responsive-enabled' ) ) : ?>
    /* Below 767px, mobiles included */
    @media (max-width: 767px) {
        .single-product div.images,
        .single-product div.summary { float:none;margin-left:0px !important;width:100% !important; }

        .single-product div.images { margin-bottom:20px; }

        /* WooCommerce standard images */
        .single-product .images .thumbnails > a { width:<?php echo min( yit_shop_thumbnail_w(), 65 ) ?>px !important; height:<?php echo min( yit_shop_thumbnail_h(), 65 ) ?>px !important; }
        /* Slider images */
        .single-product .images .thumbnails li img { max-width:<?php echo min( yit_shop_thumbnail_w(), 65 ) ?>px !important; }
    }
    <?php endif ?>
	</style>
    <?php
}

// ADD IMAGE CATEGORY OPTION
function yit_add_featured_products_slider_image_size( $options ) {  
    $tmp = $options[ count($options)-1 ];
    unset( $options[ count($options)-1 ] );
    
    $options[] = array(  
		'name' => __( 'Featured Products Widget', 'woocommerce' ),
		'desc' 		=> __( 'This size is usually used for the products thubmnails in the slider widget Featured Products.', 'yit' ),
		'id' 		=> 'woocommerce_featured_products_slider_image',
		'css' 		=> '',
		'type' 		=> 'image_width',
		'default'	=> array(
							'width' => 160,
							'height' => 160,
							'crop' => true
					   ),
		'std' 		=> array(
							'width' => 160,
							'height' => 160,
							'crop' => true
					   ),
		'desc_tip'	=>  true,
	);              
	$options[] = $tmp;     
                          
    $tmp = $options[ count($options)-1 ];
    unset( $options[ count($options)-1 ] );     
    $options[] = array(
		'name'		=> __( 'Active responsive images', 'yit' ),
		'desc' 		=> __( 'Active this to make the images responsive and adaptable to the layout grid.', 'yit' ),
		'id' 		=> 'woocommerce_responsive_images',
		'std' 		=> 'yes',
		'type' 		=> 'checkbox'
	);       
	$options[] = $tmp;
                        
    return $options;   
}

// add image size for the images of widget featured product slider
function yit_add_featured_products_slider_size( $image_sizes ) {
    $width  = get_option('woocommerce_featured_products_slider_image_width');
    $height = get_option('woocommerce_featured_products_slider_image_height');
    $image_sizes['featured_products_slider'] = array( $width, $height, true );
    return $image_sizes;    
}
add_filter( 'yit_add_image_size', 'yit_add_featured_products_slider_size' );

// ADD IMAGE RESPONSIVE OPTION
function yit_add_responsive_image_option( $options ) {
    $tmp = $options[ count($options)-1 ];
    unset( $options[ count($options)-1 ] );
    
    $options[] = array(
		'name'		=> __( 'Active responsive images', 'yit' ),
		'desc' 		=> __( 'Active this to make the images responsive and adaptable to the layout grid.', 'yit' ),
		'id' 		=> 'woocommerce_responsive_images',
		'std' 		=> 'yes',
		'type' 		=> 'checkbox'
	);              
	
	$options[] = $tmp;
                        
    return $options;   
}



/** NAV MENU
-------------------------------------------------------------------- */

add_action('admin_init', array('yiwProductsPricesFilter', 'admin_init'));

class yiwProductsPricesFilter {
	// We cannot call #add_meta_box yet as it has not been defined,
    // therefore we will call it in the admin_init hook
	function admin_init() {
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) || basename($_SERVER['PHP_SELF']) != 'nav-menus.php' ) 
			return;
			                                                    
		wp_enqueue_script('nav-menu-query', YIT_THEME_ASSETS_URL . '/js/metabox_nav_menu.js', 'nav-menu', false, true);
		add_meta_box('products-by-prices', 'Prices Filter', array(__CLASS__, 'nav_menu_meta_box'), 'nav-menus', 'side', 'low');
	}

	function nav_menu_meta_box() { ?>
	<div class="prices">        
		<input type="hidden" name="woocommerce_currency" id="woocommerce_currency" value="<?php echo get_woocommerce_currency_symbol( get_option('woocommerce_currency') ) ?>" />
		<input type="hidden" name="woocommerce_shop_url" id="woocommerce_shop_url" value="<?php echo get_option('permalink_structure') == '' ? site_url() . '/?post_type=product' : get_permalink( get_option('woocommerce_shop_page_id') ) ?>" />
		<input type="hidden" name="menu-item[-1][menu-item-url]" value="" />
		<input type="hidden" name="menu-item[-1][menu-item-title]" value="" />
		<input type="hidden" name="menu-item[-1][menu-item-type]" value="custom" />
		
		<p>
		    <?php _e( sprintf( 'The values are already expressed in %s', get_woocommerce_currency_symbol( get_option('woocommerce_currency') ) ), 'yit' ) ?>
		</p>
		
		<p>
			<label class="howto" for="prices_filter_from">
				<span><?php _e('From', 'yit'); ?></span>
				<input id="prices_filter_from" name="prices_filter_from" type="text" class="regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e('From', 'yit'); ?>" />
			</label>
		</p>

		<p style="display: block; margin: 1em 0; clear: both;">
			<label class="howto" for="prices_filter_to">
				<span><?php _e('To', 'yit'); ?></span>
				<input id="prices_filter_to" name="prices_filter_to" type="text" class="regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e('To'); ?>" />
			</label>
		</p>

		<p class="button-controls">
			<span class="add-to-menu">
				<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
				<input type="submit" class="button-secondary submit-add-to-menu" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-custom-menu-item" />
			</span>
		</p>

	</div>
<?php
	}
}     

/**
 * Add 'On Sale Filter to Product list in Admin
 */
add_filter( 'parse_query', 'on_sale_filter' );
function on_sale_filter( $query ) {
    global $pagenow, $typenow, $wp_query;

    if ( $typenow=='product' && isset($_GET['onsale_check']) && $_GET['onsale_check'] ) :

        if ( $_GET['onsale_check'] == 'yes' ) :
            $query->query_vars['meta_compare']  =  '>';
            $query->query_vars['meta_value']    =  0;
            $query->query_vars['meta_key']      =  '_sale_price';
        endif;

        if ( $_GET['onsale_check'] == 'no' ) :
            $query->query_vars['meta_value']    = '';
            $query->query_vars['meta_key']      =  '_sale_price';
        endif;

    endif;
}

add_action('restrict_manage_posts','woocommerce_products_by_on_sale');
function woocommerce_products_by_on_sale() {
    global $typenow, $wp_query;
    if ( $typenow=='product' ) :

        $onsale_check_yes = '';
        $onsale_check_no  = '';

        if ( isset( $_GET['onsale_check'] ) && $_GET['onsale_check'] == 'yes' ) :
            $onsale_check_yes = ' selected="selected"';
        endif;

        if ( isset( $_GET['onsale_check'] ) && $_GET['onsale_check'] == 'no' ) :
            $onsale_check_no = ' selected="selected"';
        endif;

        $output  = "<select name='onsale_check' id='dropdown_onsale_check'>";
        $output .= '<option value="">'.__('Show all products (Sale Filter)', 'yit').'</option>';
        $output .= '<option value="yes"'.$onsale_check_yes.'>'.__('Show products on sale', 'yit').'</option>';
        $output .= '<option value="no"'.$onsale_check_no.'>'.__('Show products not on sale', 'yit').'</option>';
        $output .= '</select>';

        echo $output;

    endif;
}


if( yit_get_option('shop-customer-vat' ) && yit_get_option('shop-customer-ssn' ) ) {

	add_filter( 'woocommerce_billing_fields' , 'woocommerce_add_billing_fields' );
	function woocommerce_add_billing_fields( $fields ) {
        //$fields['billing_country']['clear'] = true;
		$field = array('billing_ssn' => array(
	        'label'       => apply_filters( 'yit_ssn_label', __('SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_ssn_label_x', _x('SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-first'),
		    'clear'       => false
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'billing_address_1');

		$field = array('billing_vat' => array(
	        'label'       => apply_filters( 'yit_vatssn_label', __('VAT', 'yit') ),
		    'placeholder' => apply_filters( 'yit_vatssn_label_x', _x('VAT', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'billing_address_1');

		return $fields;
	} 


	add_filter( 'woocommerce_shipping_fields' , 'woocommerce_add_shipping_fields' );
	function woocommerce_add_shipping_fields( $fields ) {
		$field = array('shipping_ssn' => array(
	        'label'       => apply_filters( 'yit_ssn_label', __('SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_ssn_label_x', _x('SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-first'),
		    'clear'       => false
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'shipping_address_1');

		$field = array('shipping_vat' => array(
	        'label'       => apply_filters( 'yit_vatssn_label', __('VAT', 'yit') ),
		    'placeholder' => apply_filters( 'yit_vatssn_label_x', _x('VAT', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'shipping_address_1');
		return $fields;
	}


    add_filter( 'woocommerce_admin_billing_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    add_filter( 'woocommerce_admin_shipping_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    function woocommerce_add_billing_shipping_fields_admin( $fields ) {
        $fields['vat'] = array(
            'label' => apply_filters( 'yit_vatssn_label', __('VAT', 'yit') )
        );
        $fields['ssn'] = array(
            'label' => apply_filters( 'yit_ssn_label', __('SSN', 'yit') )
        );

        return $fields;
    }

    add_filter( 'woocommerce_load_order_data', 'woocommerce_add_var_load_order_data' );
    function woocommerce_add_var_load_order_data( $fields ) {
        $fields['billing_vat'] = '';
        $fields['shipping_vat'] = '';
        $fields['billing_ssn'] = '';
        $fields['shipping_ssn'] = '';
        return $fields;
    }



} elseif( yit_get_option('shop-customer-vat' ) ) {
	add_filter( 'woocommerce_billing_fields' , 'woocommerce_add_billing_fields' );
	function woocommerce_add_billing_fields( $fields ) {
		$fields['billing_company']['class'] = array('form-row-first');
		$fields['billing_company']['clear'] = false;
        //$fields['billing_country']['clear'] = true;
		$field = array('billing_vat' => array(
	        'label'       => apply_filters( 'yit_vatssn_label', __('VAT/SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_vatssn_label_x', _x('VAT or SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'billing_address_1');
		return $fields;
	} 
	
	add_filter( 'woocommerce_shipping_fields' , 'woocommerce_add_shipping_fields' );
	function woocommerce_add_shipping_fields( $fields ) {
		$fields['shipping_company']['class'] = array('form-row-first');
		$fields['shipping_company']['clear'] = false;
        //$fields['shipping_country']['clear'] = true;
		$field = array('shipping_vat' => array(
	        'label'       => apply_filters( 'yit_vatssn_label', __('VAT/SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_vatssn_label_x', _x('VAT or SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'shipping_address_1');
		return $fields;
	}

    add_filter( 'woocommerce_admin_billing_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    add_filter( 'woocommerce_admin_shipping_fields', 'woocommerce_add_billing_shipping_fields_admin' );
    function woocommerce_add_billing_shipping_fields_admin( $fields ) {
        $fields['vat'] = array(
            'label' => apply_filters( 'yit_vatssn_label', __('VAT/SSN', 'yit') )
        );

        return $fields;
    }

    add_filter( 'woocommerce_load_order_data', 'woocommerce_add_var_load_order_data' );
    function woocommerce_add_var_load_order_data( $fields ) {
        $fields['billing_vat'] = '';
        $fields['shipping_vat'] = '';
        return $fields;
    }
}    
elseif( yit_get_option('shop-customer-ssn' ) ) {
	add_filter( 'woocommerce_billing_fields' , 'woocommerce_add_billing_ssn_fields' );
	function woocommerce_add_billing_ssn_fields( $fields ) {
		$fields['billing_company']['class'] = array('form-row-first');
		$fields['billing_company']['clear'] = false;	
		$field = array('billing_ssn' => array(
	        'label'       => apply_filters( 'yit_ssn_label', __('SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_ssn_label_x', _x('SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'billing_address_1');
		return $fields;
	} 
	
	add_filter( 'woocommerce_shipping_fields' , 'woocommerce_add_shipping_ssn_fields' );
	function woocommerce_add_shipping_ssn_fields( $fields ) {
		$fields['shipping_company']['class'] = array('form-row-first');
		$fields['shipping_company']['clear'] = false;	
		$field = array('shipping_ssn' => array(
	        'label'       => apply_filters( 'yit_ssn_label', __('SSN', 'yit') ),
		    'placeholder' => apply_filters( 'yit_ssn_label_x', _x('SSN', 'placeholder', 'yit') ),
		    'required'    => false,
		    'class'       => array('form-row-last'),
		    'clear'       => true
	     ));
	
		yit_array_splice_assoc( $fields, $field, 'shipping_address_1');
		return $fields;
	} 
    
    add_filter( 'woocommerce_admin_billing_fields', 'woocommerce_add_billing_shipping_ssn_fields_admin' );
    add_filter( 'woocommerce_admin_shipping_fields', 'woocommerce_add_billing_shipping_ssn_fields_admin' );
    function woocommerce_add_billing_shipping_ssn_fields_admin( $fields ) {
        $fields['ssn'] = array(
    		'label' => apply_filters( 'yit_ssn_label', __('SSN', 'yit') )
  		);
        
        return $fields;
    }
    
    add_filter( 'woocommerce_load_order_data', 'woocommerce_add_var_load_order_ssn_data' );
    function woocommerce_add_var_load_order_ssn_data( $fields ) {
        $fields['billing_ssn'] = '';
        $fields['shipping_ssn'] = '';
        return $fields;
    }
}


if( yit_get_option('shop-fields-order') ) {
	add_filter( 'woocommerce_billing_fields' , 'woocommerce_restore_billing_fields_order' );
	function woocommerce_restore_billing_fields_order( $fields ) {
		$fields['billing_city']['class'][0] = 'form-row-last';
		$fields['billing_country']['class'][0] = 'form-row-first';
		$fields['billing_address_1']['class'][0] = 'form-row-first';
 		$fields['billing_address_2']['class'][0] = 'form-row-last';
		
		$country = $fields['billing_country'];
		unset( $fields['billing_country'] );
		yit_array_splice_assoc( $fields, array('billing_country' => $country), 'billing_state' );

		return $fields;
	}

	add_filter( 'woocommerce_shipping_fields' , 'woocommerce_restore_shipping_fields_order' );
	function woocommerce_restore_shipping_fields_order( $fields ) {
		$fields['shipping_city']['class'][0] = 'form-row-last';
		$fields['shipping_country']['class'][0] = 'form-row-first';		
		$fields['shipping_address_1']['class'][0] = 'form-row-first';
 		$fields['shipping_address_2']['class'][0] = 'form-row-last';
		
		$country = $fields['shipping_country'];
		unset( $fields['shipping_country'] );
		yit_array_splice_assoc( $fields, array('shipping_country' => $country), 'shipping_state' );

		return $fields;
	}
}


/* is image responsive enabled? */
function yit_print_image_responsive_enabled_variables() {
    global $woocommerce_loop, $yit_is_feature_tab;
    
    $content_width = yit_get_sidebar_layout() == 'sidebar-no' ? 1170 : 870;   
    if ( isset( $yit_is_feature_tab ) && $yit_is_feature_tab ) $content_width -= 300;
    $product_width = yit_shop_small_w() + 10 + 2;  // 10 = padding & 2 = border                       
    $is_span = false;
    if ( get_option('woocommerce_responsive_images') == 'yes' ) {
        $is_span = true;
        if ( yit_get_sidebar_layout() == 'sidebar-no' ) {
                if ( $product_width >= 0   && $product_width < 120 ) { $woocommerce_loop['li_class'][] = 'span1'; $woocommerce_loop['columns'] = 12; }
            elseif ( $product_width >= 120 && $product_width < 220 ) { $woocommerce_loop['li_class'][] = 'span2'; $woocommerce_loop['columns'] = 6;  }
            elseif ( $product_width >= 220 && $product_width < 320 ) { $woocommerce_loop['li_class'][] = 'span3'; $woocommerce_loop['columns'] = 4;  }
            elseif ( $product_width >= 320 && $product_width < 470 ) { $woocommerce_loop['li_class'][] = 'span4'; $woocommerce_loop['columns'] = 3;  }
            elseif ( $product_width >= 470 && $product_width < 620 ) { $woocommerce_loop['li_class'][] = 'span6'; $woocommerce_loop['columns'] = 2;  }  
            else $is_span = false;
            
        } else {    
                if ( $product_width >= 0   && $product_width < 150 ) { $woocommerce_loop['li_class'][] = 'span1'; $woocommerce_loop['columns'] = 12; }
            elseif ( $product_width >= 150 && $product_width < 620 ) { $woocommerce_loop['li_class'][] = 'span3'; $woocommerce_loop['columns'] = 3;  } 
            else $is_span = false;
            
        }
            
    } else {
        $grid = yit_get_span_from_width( $product_width );
        $woocommerce_loop['li_class'][] = 'span' . $grid;
        $product_width = yit_width_of_span( $grid );
    }         
    if ($yit_is_feature_tab || ! $is_span ) $woocommerce_loop['columns'] = floor( ( $content_width + 30 ) / ( $product_width + 30 ) );  
?>
<script type="text/javascript">
var elastislide_defaults = {
	imageW: <?php echo get_option('woocommerce_responsive_images') == 'no' || ! get_option('woocommerce_responsive_images') ? yit_shop_small_w() + 10 + 2 : '"100%"'; ?>,
	border		: 0,
	margin      : 0,
	preventDefaultEvents: false,
	infinite : true,
	slideshowSpeed : 3500
};

var carouFredSelOptions_defaults = {
	responsive: false,
	auto: true,
	items: <?php echo empty( $woocommerce_loop['columns'] ) ? 0 : $woocommerce_loop['columns'] ?>,
	circular: true,
	infinite: true,
	debug: false,
    prev: '.es-nav .es-nav-prev',
    next: '.es-nav .es-nav-next',
    swipe: {
       	onTouch: true
    },
    scroll : {
    	items     : 1,
    	pauseOnHover: true
    } 
};


</script>
<?php
}
add_action( 'wp_footer', 'yit_print_image_responsive_enabled_variables', 1 );
add_action( 'yit_after_import', create_function( '', 'update_option("woocommerce_responsive_images", "yes");' ) );



/**
 * Return the following cart info:
 * 	- items
 *  - subtotal
 *  - currency
 * 
 * @return array
 */
function yit_get_current_cart_info() {
	global $woocommerce;

    if( get_option( 'woocommerce_tax_display_cart' ) == 'excl' || $woocommerce->customer->is_vat_exempt() ) {
        $subtotal = $woocommerce->cart->subtotal_ex_tax;
    } else {
        $subtotal = $woocommerce->cart->subtotal;
    }

    $items = yit_get_option( 'minicart-total-items' ) ? $woocommerce->cart->get_cart_contents_count() : count( $woocommerce->cart->get_cart() );

    return array(
        $items,
        $subtotal,
        get_woocommerce_currency_symbol()
    );
}

function yit_format_cart_subtotal( $price ) {
	$num_decimals = (int) get_option( 'woocommerce_price_num_decimals' );
	
	$price = apply_filters( 'raw_woocommerce_price', (double) $price );
	$price = number_format( $price, $num_decimals, stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ), stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ) );
	
	return explode(get_option( 'woocommerce_price_decimal_sep' ), $price);
}

function yit_add_to_cart_success_ajax( $datas ) {
	global $woocommerce;
	
	list( $cart_items, $cart_subtotal, $cart_currency ) = yit_get_current_cart_info();

	$datas['#header-cart-search .cart-items-number'] = '<span class="cart-items-number">' . $cart_items . '</span>';
	$datas['#header-cart-search .cart-items-label'] = '<span class="cart-items-label">' . ($cart_items != 1 ? __("Items", 'yit') : __('Item', 'yit')) . '</span>';

	list( $cart_integer, $cart_decimal ) = yit_format_cart_subtotal( $cart_subtotal );

	$datas['#header-cart-search .cart-subtotal-integer'] = '<span class="cart-subtotal-integer">' . $cart_integer . '</span>';
	$datas['#header-cart-search .cart-subtotal-decimal'] = '<span class="cart-subtotal-decimal">' . $cart_decimal . '</span>';
	$datas['#header-cart-search .cart-subtotal-currency'] = '<span class="cart-subtotal-currency">' . $cart_currency . '</span>';
	
	return $datas;
}
add_filter( 'add_to_cart_fragments', 'yit_add_to_cart_success_ajax' );


/* COMPARE */

function yit_woocp_footer_script() {
	$woocp_compare_events = wp_create_nonce("woocp-compare-events");
// 	$woocp_compare_popup = wp_create_nonce("woocp-compare-popup");
// 	$comparable_settings = get_option('woo_comparable_settings');
// 	if (trim($comparable_settings['popup_width']) != '') $popup_width = $comparable_settings['popup_width'];
// 	else $popup_width = 1000;
// 
// 	if (trim($comparable_settings['popup_height']) != '') $popup_height = $comparable_settings['popup_height'];
// 	else $popup_height = 650;

	$script_add_on = '';
	$script_add_on .= '<script type="text/javascript">
			jQuery(document).ready(function($){';
	$script_add_on .= '
					woo_update_total_compare_list = function(){ 
						var data = {
							action: 		"woocp_update_total_compare",
							security: 		"'.$woocp_compare_events.'"
						};
						$.post( ajax_url, data, function(response) {
							total_compare = $.parseJSON( response );
							$("#total_compare_product").html("("+total_compare+")");
                            $(".woo_compare_button_go").trigger("click");'; 
// 	if (trim($comparable_settings['popup_type']) == 'lightbox') {
//         $script_add_on .= '
//                             $.lightbox(ajax_url+"?action=woocp_get_popup&security='.$woocp_compare_popup.'", {
//                                 "width"       : '.$popup_width.',
//                                 "height"      : '.$popup_height.'
//                             });';
// 	}else {
//         $script_add_on .= '
//     						$.fancybox({
//     							href: ajax_url+"?action=woocp_get_popup&security='.$woocp_compare_popup.'",
//     							title: "Compare Products",
//     							maxWidth: '.$popup_width.',
//     							maxHeight: '.$popup_height.',
//     							openEffect	: "none",
//     							closeEffect	: "none"
//     						});';
// 	}
	
	$script_add_on .= '
    					});
					};

				});
			</script>';
	echo $script_add_on;
}


/**
 * Add default images dimensions to woocommerce options
 * 
 */
function yit_woocommerce_default_image_dimensions() {
	$field = 'yit_woocommerce_image_dimensions_' . get_template();
	
	if( get_option($field) == false ) {
		update_option($field, time());
		
		//woocommerce 1.6.6
		update_option( 'woocommerce_thumbnail_image_width', '100' );
		update_option( 'woocommerce_thumbnail_image_height', '80' );
		update_option( 'woocommerce_single_image_width', '462' );
		update_option( 'woocommerce_single_image_height', '392' ); 
		update_option( 'woocommerce_catalog_image_width', '254' );
		update_option( 'woocommerce_catalog_image_height', '203' );
		update_option( 'woocommerce_magnifier_image_width', '924' );
		update_option( 'woocommerce_magnifier_image_height', '784' );
		update_option( 'woocommerce_featured_products_slider_image_width', '160' );
		update_option( 'woocommerce_featured_products_slider_image_height', '160' );
		
		update_option( 'woocommerce_thumbnail_image_crop', 1 );
		update_option( 'woocommerce_single_image_crop', 1 ); 
		update_option( 'woocommerce_catalog_image_crop', 1 );
		update_option( 'woocommerce_magnifier_image_crop', 1 );
		update_option( 'woocommerce_featured_products_slider_image_crop', 1 );
		
		//woocommerce 2.0
		update_option( 'shop_thumbnail_image_size', array( 'width' => 100, 'height' => 80, 'crop' => true ) );
		update_option( 'shop_single_image_size', array( 'width' => 462, 'height' => 392, 'crop' => true ) ); 
		update_option( 'shop_catalog_image_size', array( 'width' => 254, 'height' => 203, 'crop' => true ) );
		update_option( 'woocommerce_magnifier_image', array( 'width' => 924, 'height' => 784, 'crop' => true ) );
		update_option( 'woocommerce_featured_products_slider_image', array( 'width' => 160, 'height' => 160, 'crop' => true ) );
	}
}



/**
 * Backup woocoomerce options when create the export gz
 * 
 */
function yit_save_woocommerce_tables( $tables ) {
	$tables[] = 'woocommerce_termmeta';
	$tables[] = 'woocommerce_attribute_taxonomies';
	return $tables;
} 

/**
 * Backup woocoomerce options when create the export gz
 * 
 */
function yit_save_woocommerce_options( $options ) {
	$options[] = 'woocommerce\_%';
	return $options;
} 

/**
 * Backup woocoomerce wishlist when create the export gz
 * 
 */
function yit_save_wishlist_options( $options ) {
	$options[] = 'yith\_wcwl\_%';
	$options[] = 'yith-wcwl-%';
	return $options;
} 

/**
 * Update woocommerce options after update from 1.6 to 2.0
 */
function yit_woocommerce_update() {
	global $woocommerce; 
	
	$field = 'yit_woocommerce_update_' . get_template();
	
	if( get_option($field) == false && version_compare($woocommerce->version,"2.0.0",'>=') ) {
		update_option($field, time());

		//woocommerce 2.0
		update_option( 
			'shop_thumbnail_image_size', 
			array( 
				'width' => get_option('woocommerce_thumbnail_image_width', 100), 
				'height' => get_option('woocommerce_thumbnail_image_height', 80),
				'crop' => get_option('woocommerce_thumbnail_image_crop', 1)
			)
		);
		
		update_option( 
			'shop_single_image_size', 
			array( 
				'width' => get_option('woocommerce_single_image_width', 462 ), 
				'height' => get_option('woocommerce_single_image_height', 392 ),
				'crop' => get_option('woocommerce_single_image_crop', 1)
			) 
		); 
		
		update_option( 
			'shop_catalog_image_size', 
			array( 
				'width' => get_option('woocommerce_catalog_image_width', 254 ), 
				'height' => get_option('woocommerce_catalog_image_height', 203 ),
				'crop' => get_option('woocommerce_catalog_image_crop', 1)
			) 
		);
		
		update_option( 
			'woocommerce_magnifier_image', 
			array( 
				'width' => get_option('woocommerce_magnifier_image_width', 924 ),
				'height' => get_option('woocommerce_magnifier_image_height', 784 ),
				'crop' => get_option('woocommerce_magnifier_image_crop', 1)
			) 
		);
		
		update_option( 
			'woocommerce_featured_products_slider_image', 
			array( 
				'width' => get_option('woocommerce_featured_products_slider_image_width', 160 ),
				'height' => get_option('woocommerce_featured_products_slider_image_height', 160 ),
				'crop' => get_option('woocommerce_featured_products_slider_image_crop', 1)
			) 
		);
	}
}