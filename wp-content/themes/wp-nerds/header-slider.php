
<?php
/**
 * Template part for displaying a slider in header
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-Nerds
 */

?>

<div class="main-header-content">
                    <div class="slider <?php if( is_customize_preview() ){ echo 'slides__preview';} ?>">
                        <input type="radio" id="point1" name="r" checked="checked">
                        <input type="radio" id="point2" name="r">
                        <input type="radio" id="point3" name="r">
                        <div class="slider-controls">
                            <label class="label1" for="point1"></label>
                            <label class="label2" for="point2"></label>
                            <label class="label3" for="point3"></label>
                        </div>
                        <?php if( is_customize_preview() ){
                                echo "<button class='btn_map btn_map--one' type='submit' value='slide-one'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z'></path></svg>
                                </button>";
                            } ?>
                        <?php if( is_customize_preview() ){
                                echo "<button class='btn_map btn_map--two' type='submit' value='slide-two'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z'></path></svg>
                                </button>";
                            } ?>
                        <?php if( is_customize_preview() ){
                                echo "<button class='btn_map btn_map--three' type='submit' value='slide-three'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z'></path></svg>
                                </button>";
                            } ?>  
                        <div class="slides">
                            <section class="slide slide-one">
                                <div class="slide-info slide-info-1">
                                    <b><?php echo get_theme_mod( 'tcx_slider_title_1' ); ?></b>
                                    <p><?php echo get_theme_mod( 'tcx_slider_discription_1' ); ?></p>
                                    <a class="btn" href="#">Узнать больше</a>
                                    <img src="<?php echo get_theme_mod( 'tcx_slider_image1' ); ?>" width="338" height="231" alt="">
                                    <!-- <img src="<?php bloginfo('template_directory')?>/img/index-slider-1.png" width="338" height="231" alt=""> -->
                                </div>
                            </section>
                            <section class="slide slide-two">
                                <div class="slide-info slide-info-2">
                                    <b><?php echo get_theme_mod( 'tcx_slider_title_2' ); ?></b>
                                    <p><?php echo get_theme_mod( 'tcx_slider_discription_2' ); ?></p>
                                    <a class="btn" href="#">Узнать больше</a>
                                    <img src="<?php echo get_theme_mod( 'tcx_slider_image2' ); ?>" width="230" height="249" alt="">
                                    <!-- <img src="<?php bloginfo('template_directory')?>/img/index-slider-2.png" width="230" height="249" alt=""> -->
                                </div>
                            </section>
                            <section class="slide slide-three">
                                <div class="slide-info slide-info-3">
                                    <b><?php echo get_theme_mod( 'tcx_slider_title_3' ); ?></b>
                                    <p><?php echo get_theme_mod( 'tcx_slider_discription_3' ); ?></p>
                                    <a class="btn" href="#">Узнать больше</a>
                                    <img src="<?php echo get_theme_mod( 'tcx_slider_image3' ); ?>" width="333" height="319" alt="">
                                    <!-- <img src="<?php bloginfo('template_directory')?>/img/index-slider-3.png" width="333" height="319" alt=""> -->
                                </div>
                            </section>
                        </div>
                    </div>
</div>
