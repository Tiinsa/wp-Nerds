<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

//if( ! is_shop_enabled() ) return;

global $post, $product;
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	<?php if($product->get_price_html() != "" ) : ?>
		<p itemprop="price" class="price">
			<?php if($product->product_type != 'variable') : ?>
				<!--<span class="price-label"><?php echo __('Price','yit') ?>: </span>-->
			<?php endif ?>
			<?php echo $product->get_price_html(); ?>
		</p>
	<?php endif ?>
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

</div>