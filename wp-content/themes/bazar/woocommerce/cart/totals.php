<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce;

$available_methods = $woocommerce->shipping->get_available_shipping_methods(); ?>
<div class="span6 cart_totals <?php if ( $woocommerce->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">
	<div class="border-1 border">
		<div class="border-2 border">
			
	<?php do_action('woocommerce_before_cart_totals'); ?>

	<?php if ( ! $woocommerce->shipping->enabled || $available_methods || ! $woocommerce->customer->get_shipping_country() || ! $woocommerce->customer->has_calculated_shipping() ) : ?>

		<h2><?php _e('Cart Totals', 'yit'); ?></h2>
		<table align="right" cellspacing="0" cellpadding="0">
			<tbody>

				<tr class="cart-subtotal">
					<th><strong><?php _e('Cart Subtotal', 'yit'); ?></strong></th>
					<td><strong><?php echo $woocommerce->cart->get_cart_subtotal(); ?></strong></td>
				</tr>

				<?php if ($woocommerce->cart->get_discounts_before_tax()) : ?>

				<tr class="discount">
					<th><?php _e('Cart Discount', 'yit'); ?> <a href="<?php echo add_query_arg('remove_discounts', '1', $woocommerce->cart->get_cart_url()) ?>"><?php _e('[Remove]', 'yit'); ?></a></th>
					<td>-<?php echo $woocommerce->cart->get_discounts_before_tax(); ?></td>
				</tr>

				<?php endif; ?>

				<?php if ( $woocommerce->cart->needs_shipping() && $woocommerce->cart->show_shipping() && ( $available_methods || get_option( 'woocommerce_enable_shipping_calc' ) == 'yes' ) ) { ?>

				<tr class="shipping">
					<th><?php _e('Shipping', 'yit'); ?></th>
					<td><?php woocommerce_get_template( 'cart/shipping-methods.php', array( 'available_methods' => $available_methods ) ); ?></td>
				</tr>

				<?php } ?>

				<?php
					if ( get_option('woocommerce_display_cart_taxes') == 'yes' && $woocommerce->cart->get_cart_tax() ) :

						$taxes = $woocommerce->cart->get_formatted_taxes();

						if (sizeof($taxes)>0) :

							$has_compound_tax = false;

							foreach ($taxes as $key => $tax) :
								if ($woocommerce->cart->tax->is_compound( $key )) : $has_compound_tax = true; continue; endif;
								?>
								<tr class="tax-rate tax-rate-<?php echo $key; ?>">
									<th>
										<?php
										if ( get_option( 'woocommerce_display_totals_excluding_tax' ) == 'no' && get_option( 'woocommerce_prices_include_tax' ) == 'yes' ) {
											_e( 'incl.&nbsp;', 'yit' );
										}
										echo $woocommerce->cart->tax->get_rate_label( $key );
										?>
									</th>
									<td><?php echo $tax; ?></td>
								</tr>
								<?php

							endforeach;

							if ($has_compound_tax && !$woocommerce->cart->prices_include_tax) :
								?>
								<tr class="order-subtotal">
									<th><strong><?php _e('Subtotal', 'yit'); ?></strong></th>
									<td><strong><?php echo $woocommerce->cart->get_cart_subtotal( true ); ?></strong></td>
								</tr>
								<?php
							endif;

							foreach ($taxes as $key => $tax) :
								if (!$woocommerce->cart->tax->is_compound( $key )) continue;
								?>
								<tr class="tax-rate tax-rate-<?php echo $key; ?>">
									<th>
										<?php
										if ( get_option( 'woocommerce_display_totals_excluding_tax' ) == 'no' && get_option( 'woocommerce_prices_include_tax' ) == 'yes' ) {
											_e( 'incl.&nbsp;', 'yit' );
										}
										echo $woocommerce->cart->tax->get_rate_label( $key );
										?>
									</th>
									<td><?php echo $tax; ?></td>
								</tr>
								<?php

							endforeach;

						else :

							?>
							<tr class="tax">
								<th><?php _e('Tax', 'yit'); ?></th>
								<td><?php echo $woocommerce->cart->get_cart_tax(); ?></td>
							</tr>
							<?php

						endif;
					elseif ( get_option('woocommerce_display_cart_taxes_if_zero') == 'yes' ) :

						?>
						<tr class="tax">
							<th><?php _e('Tax', 'yit'); ?></th>
							<td><?php _ex( 'N/A', 'Relating to tax', 'yit' ); ?></td>
						</tr>
						<?php

					endif;
				?>

				<?php if ($woocommerce->cart->get_discounts_after_tax()) : ?>

				<tr class="discount">
					<th><?php _e('Order Discount', 'yit'); ?> <a href="<?php echo add_query_arg('remove_discounts', '2', $woocommerce->cart->get_cart_url()) ?>"><?php _e('[Remove]', 'yit'); ?></a></th>
					<td>-<?php echo $woocommerce->cart->get_discounts_after_tax(); ?></td>
				</tr>

				<?php endif; ?>

				<tr class="total">
					<th><strong><?php _e('Order Total', 'yit'); ?></strong></th>
					<td><strong><?php

						if (get_option('woocommerce_display_cart_taxes')=='no' && !$woocommerce->cart->prices_include_tax) :
							echo $woocommerce->cart->get_total_ex_tax();
						else :
							echo $woocommerce->cart->get_total();
						endif;

					?></strong></td>
				</tr>

			</tbody>
		</table>

		<?php if ( get_option('woocommerce_display_cart_taxes') == 'yes' && $woocommerce->cart->get_cart_tax() ) : ?>
			<p><small><?php

				$estimated_text = ( $woocommerce->customer->is_customer_outside_base() && ! $woocommerce->customer->has_calculated_shipping() ) ? sprintf( ' ' . __('(taxes estimated for %s)', 'yit'), $woocommerce->countries->estimated_for_prefix() . __($woocommerce->countries->countries[ $woocommerce->countries->get_base_country() ], 'yit') ) : '';

				printf(__('Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'yit'), $estimated_text );

			?></small></p>
		<?php endif; ?>

	<?php elseif( $woocommerce->cart->needs_shipping() ) : ?>

		<?php if ( ! $woocommerce->customer->get_shipping_state() || ! $woocommerce->customer->get_shipping_postcode() ) : ?>

			<div class="woocommerce_info">
				<p><?php _e('No shipping methods were found; please recalculate your shipping and enter your state/county and zip/postcode to ensure their are no other available methods for your location.', 'yit'); ?></p>
			</div>

		<?php else : ?>

			<div class="woocommerce_error">

				<p><?php printf(__('Sorry, it seems that there are no available shipping methods for your location (%s).', 'yit'), $woocommerce->countries->countries[ $woocommerce->customer->get_shipping_country() ]); ?></p>

				<p><?php _e('If you require assistance or wish to make alternate arrangements please contact us.', 'yit'); ?></p>

			</div>

		<?php endif; ?>

	<?php endif; ?>

	<?php do_action('woocommerce_after_cart_totals'); ?>
	
			<div class="clear"></div>
		</div>
	</div>
</div>