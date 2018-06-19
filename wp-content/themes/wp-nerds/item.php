<?php
/**
 * Template Name: Item Page
 * The template for displaying all pages
 * Template Post Type: post
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-Nerds
 */

get_header(); ?>
	
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();
?>

<?php 
// $custom_fields = get_post_custom(the_ID());
// var_dump( $custom_fields );
//   $my_custom_field = $custom_fields['price'];
//   foreach ( $my_custom_field as $key => $value ) {
//     echo $key . " => " . $value . "<br />";
//   }
?>
  <?php $meta = get_post_meta( get_the_ID() ); 
  		//var_dump( $meta );
  		// if ( $meta['price'] ) {
  		// 	?>
  		 	<!-- <p>Meta information for this post:</p> -->
		 <?php
		// the_meta(); 
				
  		// }
		if ( array_key_exists('price', $meta) ) {
  			?>
  		 	<p>Meta information for this post:</p>
		<?php the_meta();
		?><h2><?php the_title(); ?></h2><br>
	<?php	//get_template_part( 'template-parts/content', 'page' ); 
		
		
     the_post_thumbnail(); ?> <br>
    <?php the_excerpt(); 
				
		}
?>  




				


<?php
				

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
