<?php
/**
 * Template part for displaying a features in home-page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-Nerds
 */

?>

<section class="features clearfix">
                <div class="features-item <?php if( is_customize_preview() ){ echo 'features__preview';} ?>">
                    <?php if( is_customize_preview() ){
                                echo "<button class='btn_map btn_map--features' type='submit' value='features-one'>
                                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z'></path></svg>
                                    </button>";
                            } ?>
                    <h2 class="features-name"><?php echo get_theme_mod( 'features_title_1' ); ?></h2>
                    <p><?php echo get_theme_mod( 'features_discription_1' ); ?></p>
                    <a class="btn" href="#">Заказать</a>
                </div>
                <div class="features-item <?php if( is_customize_preview() ){ echo 'features__preview';} ?>">
                    <?php if( is_customize_preview() ){
                                echo "<button class='btn_map btn_map--features' type='submit' value='features-two'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z'></path></svg>
                                </button>";
                            } ?>
                    <h2 class="features-name"><?php echo get_theme_mod( 'features_title_2' ); ?></h2>
                    <p><?php echo get_theme_mod( 'features_discription_2' ); ?></p>
                    <a class="btn btn-green" href="#">Заказать</a>
                </div>
                <div class="features-item <?php if( is_customize_preview() ){ echo 'features__preview';} ?>">
                    <?php if( is_customize_preview() ){
                                echo "<button class='btn_map btn_map--features' type='submit' value='features-three'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z'></path></svg>
                                </button>";
                            } ?>
                    <h2 class="features-name"><?php echo get_theme_mod( 'features_title_3' ); ?></h2>
                    <p><?php echo get_theme_mod( 'features_discription_3' ); ?></p>
                    <a class="btn btn-yellow" href="#">Заказать</a>
                </div>
            </section>