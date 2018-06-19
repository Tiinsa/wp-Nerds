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
 
if ( ! is_product() ) return;

global $product, $woocommerce, $post;

$count_buttons = 3;    // number of buttons to show
$wishlist = do_shortcode('[yith_wcwl_add_to_wishlist]');
$compare  = function_exists('woo_add_compare_button') ? woo_add_compare_button() : '';
$share    = sprintf('<a href="%s" rel="nofollow" title="%s" class="share" id="%s" onclick="return false;">%s</a>', '#', __( 'Share', 'yit' ), "share_$product->id", __( 'Share', 'yit' ));
if ( ! yit_get_option('shop-single-show-wishlist' ) ) { $wishlist = ''; } 
if ( ! yit_get_option('shop-single-show-compare') )   { $compare  = ''; } 
if ( ! yit_get_option('shop-single-show-share') )     { $share    = ''; }  

if ( !( isset( $woocommerce->integrations->integrations['sharethis'] ) && $woocommerce->integrations->integrations['sharethis']->publisher_id ) ) {
    $share = '';
}

if ( get_option( 'yith_wcwl_enabled' ) != 'yes' ) { $wishlist = ''; }

if ( ! empty( $compare ) ) $compare .= '<a href="#" class="woo_compare_button_go hide" style="display: none;"></a>';

$buttons = array( $wishlist, $compare, $share );

foreach ( array( 'wishlist', 'compare', 'share' ) as $var ) if ( empty( ${$var} ) ) $count_buttons--;
?>
 
<div class="product-box group">
    <div class="border group">
        
        <?php do_action( 'yit_product_box' ); ?>
        
        <div class="border borderstrong"></div>
        <div class="border"></div>
        <div class="border"></div>
        <div class="border"></div>
        
        <div class="buttons buttons_<?php echo $count_buttons ?> group"> 
            <?php echo implode( "\n", $buttons ) ?>
        </div>
    
    </div>
</div>

<?php yit_add_sharethis_button_js(); ?>