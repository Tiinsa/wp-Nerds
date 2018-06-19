<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce;
//if ( ! $product->is_purchasable() ) return;

$woocommerce->integrations->integrations['sharethis']->sharethis_code = ''; // remove the code of share this and leave the js scripts                                    

$count_buttons = 4;    // number of buttons to show
$details  = sprintf('<a href="%s" rel="nofollow" title="%s" class="details">%s</a>', get_permalink(), __( 'Details', 'yit' ), __( 'Details', 'yit' ));
$wishlist = do_shortcode('[yith_wcwl_add_to_wishlist]');
$compare  = function_exists('woo_add_compare_button') ? woo_add_compare_button() : '';
$share    = sprintf('<a href="%s" rel="nofollow" title="%s" class="share" id="%s" onclick="return false;">%s</a>', '#', __( 'Share', 'yit' ), "share_$product->id", __( 'Share', 'yit' ));
if ( ! yit_get_option('shop-view-show-details') )  { $details  = ''; }              
if ( ! ( yit_get_option('shop-view-show-wishlist') && get_option( 'yith_wcwl_enabled' ) == 'yes' ) ) 
                                                   { $wishlist = ''; } 
if ( ! yit_get_option('shop-view-show-compare') )  { $compare  = ''; } 
if ( ! yit_get_option('shop-view-show-share') )    { $share    = ''; }      
  
if ( !( isset( $woocommerce->integrations->integrations['sharethis'] ) && $woocommerce->integrations->integrations['sharethis']->publisher_id ) ) { $share = ''; }

$buttons = array( $details, $wishlist, $compare, $share );
foreach ( array( 'details', 'wishlist', 'compare', 'share' ) as $var ) if ( empty( ${$var} ) ) $count_buttons--;

if ( ! is_shop_enabled() || ! yit_get_option('shop-view-show-add-to-cart') || ! $product->is_purchasable() ) :
    $add_to_cart = ''; 
    $out_of_stock = '';

elseif ( ! $product->is_in_stock() ) : $add_to_cart = ''; $label = apply_filters( 'out_of_stock_add_to_cart_text', __( 'Out of stock', 'yit' ) ); ?>

	<?php $out_of_stock = sprintf( '<a class="out-of-stock" title="%s">%s</a>', $label, $label ); ?>

<?php else : ?>

	<?php
	
	   $add_to_cart = '';
	   $out_of_stock = '';

		switch ( $product->product_type ) {
			case "variable" :
				$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
				$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', 'yit') );
				$add_to_cart = sprintf('<a href="%s" rel="nofollow" class="view-options" title="%s">%s</a>', $link, $label, $label);
			break;
			case "grouped" :
				$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
				$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', 'yit') );   
				$add_to_cart = sprintf('<a href="%s" rel="nofollow" class="view-options" title="%s">%s</a>', $link, $label, $label);
			break;
			case "external" :
				$link 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
				$label 	= apply_filters( 'external_add_to_cart_text', __('Read More', 'yit') );    
				$add_to_cart = sprintf('<a href="%s" rel="nofollow" class="view-options" title="%s">%s</a>', $link, $label, $label);
			break;
			default :
				$link 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
				$label 	= apply_filters( 'add_to_cart_text', __('Add to cart', 'yit') );
                $quantity = apply_filters( 'add_to_cart_quantity', ( get_post_meta( $product->id, 'minimum_allowed_quantity', true ) ? get_post_meta( $product->id, 'minimum_allowed_quantity', true ) : 1 ) );
				$add_to_cart = sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-quantity="%s" class="add_to_cart_button button product_type_%s" title="%s">%s</a>', $link, $product->id, $quantity, $product->product_type, $label, $label);
			break;
		}
        
	?>

<?php endif; ?>

<?php if ( ! empty( $add_to_cart ) || ! empty( $details ) ) : ?>
<div class="product-actions-wrapper">
    <div class="product-actions">   
        <?php if ( yit_get_option('shop-view-show-rating') ) echo $product->get_rating_html('shop_loop'); ?>
        <?php echo $out_of_stock; ?>
        <?php if ( $product->is_purchasable() ) echo $add_to_cart; ?>
        <div class="buttons buttons_<?php echo $count_buttons ?> group"> 
            <?php echo implode("\n", $buttons) ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php yit_add_sharethis_button_js() ?>