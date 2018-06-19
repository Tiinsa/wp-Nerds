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
$show_cart        = yit_get_option('show-header-woocommerce-cart');
$show_cart_widget = yit_get_option('show-header-woocommerce-cart-widget');
$show_search      = yit_get_option('show-header-search');

if( ! is_shop_installed() || ! is_shop_enabled() ) $show_cart = $show_cart_widget = false;

$responsive_header_cart   = yit_get_option('responsive-show-header-cart');
$responsive_header_search = yit_get_option('responsive-show-header-search');

if ( ! $show_cart && ! $show_cart_widget && ! $show_search ) return;
?>
<div id="header-cart-search">
    <?php if( $show_cart || $show_cart_widget ): ?>
    <div class="cart-row group<?php if ( ! $responsive_header_cart ) echo ' hidden-phone' ?>">
        <?php if( $show_cart ): ?>
            <?php list( $cart_items, $cart_subtotal, $cart_currency ) = yit_get_current_cart_info(); ?>
            <?php list( $cart_integer, $cart_decimal ) = yit_format_cart_subtotal( $cart_subtotal ); ?>

            <?php if( $show_cart_widget ): ?>
                <?php the_widget('YIT_Widget_Cart') ?>
                <?php endif ?>

            <div class="cart-subtotal">
                <?php if( strpos( get_option( 'woocommerce_currency_pos' ), 'left' ) !== false ) : ?>
                <span class="cart-subtotal-currency"><?php echo $cart_currency ?></span>
                <?php endif; ?>
                <span class="cart-subtotal-integer"><?php echo $cart_integer ?></span>
                <span class="cart-subtotal-decimal"><?php echo $cart_decimal ?></span>
                <?php if( strpos( get_option( 'woocommerce_currency_pos' ), 'right' ) !== false ) : ?>
                <span class="cart-subtotal-currency"><?php echo $cart_currency ?></span>
                <?php endif; ?>
            </div>

            <div class="cart-items cart-items-icon">
                <span class="cart-items-number"><?php echo $cart_items ?></span>
                <span class="cart-items-label"><?php echo $cart_items != 1 ? __('Items', 'yit') : __('Item', 'yit') ?></span>
            </div>
        <?php endif ?>
    </div>
    <?php endif ?>

    <?php if( $show_search ): ?>
    <?php if ( ! $responsive_header_search ) { ?><div class="hidden-phone"><?php } the_widget('search_mini'); if ( ! $responsive_header_search ) { ?></div><?php } ?>
    <?php endif ?>
</div>