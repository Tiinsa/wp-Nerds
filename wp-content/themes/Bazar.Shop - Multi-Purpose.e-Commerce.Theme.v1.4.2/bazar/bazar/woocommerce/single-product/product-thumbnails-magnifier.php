<?php
/**
 * Single Product Image
 *
 * @author 		YIThemes
 * @package 	YITH_Magnifier/Templates
 * @version     1.0.0
 */
          
global $post, $product, $woocommerce;    

$columns = apply_filters( 'woocommerce_product_thumbnails_columns', get_option('yith_wcmg_slider_items',4) );  

?>
<div class="thumbnails"><?php
	$attachment_ids = $product->get_gallery_attachment_ids();
	
	if ( $attachment_ids ) {
		echo '<ul class="yith_magnifier_gallery">';


		$loop = 0;

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array();

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$attachment_url = wp_get_attachment_url( $attachment_id );

			if ( ! $attachment_url )
				continue;

			list( $thumbnail_url, $thumbnail_width, $thumbnail_height ) = yit_image( "id=$attachment_id&size=shop_single&output=array" );
			list( $magnifier_url, $magnifier_width, $magnifier_height ) = yit_image( "id=$attachment_id&size=shop_magnifier&output=array" );

			printf( '<li><a href="%s" title="%s" rel="thumbnails" class="%s" data-small="%s">%s</a></li>', yit_image( 'size=shop_magnifier&output=url&id=' . $attachment_id, false ), esc_attr( '' ), implode(' ', $classes), yit_image( 'size=shop_single&output=url&id=' . $attachment_id, false ), yit_image( 'size=shop_thumbnail&id=' . $attachment_id, false ) );

			$loop++;

		}

		echo '</ul>';
	}
?>

<div id="slider-prev"></div>
<div id="slider-next"></div>
</div>