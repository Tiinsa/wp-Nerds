<?php 
get_header();
// get_custom_header();
 ?>

<?php the_post(); ?>
<?php	
					if (is_home() || is_front_page()) {
						get_template_part( 'content', 'features' );
					}
				?>	
<?php the_content(); ?>

<?php //get_sidebar('sidebar-1');?>

<?php //get_sidebar('sidebar-2');?>



<?php
	// if ( function_exists('dynamic_sidebar') )
	// 	dynamic_sidebar('sidebar-2');
?>

<?php
	// if ( function_exists('dynamic_sidebar') )
	// 	dynamic_sidebar('sidebar-1');
?>

<?php if( is_customize_preview() ){
	// echo "<script> console.log ('is_customize_preview home page'); </script>";
	// echo "<button class='btn btn_map' type='submit'>Открыть панель настроек карты</button>
	// 	<script>
	// 		console.log ('is_customize_preview home page');
			
	// 	</script>	
	// ";
}?>



<?php get_footer(); ?>
