<?php
/**
 * Template Name: Gallery Page
 * The template for displaying all pages
 * Template Post Type: page
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

get_header();
if(session_id() == '')
session_start();

if (!isset($_SESSION['query_items'])) $_SESSION['query_items'] = array();
$query_items = $_SESSION['query_items'];

$orderby = isset($query_items['orderby']) ? $query_items['orderby'] : array();
$price_range = isset($query_items['price_range']) ? $query_items['price_range'] : array();
$type_greed = isset($query_items['type_greed']) ? $query_items['type_greed'] : array();
$type_features = isset($query_items['type_features']) ? $query_items['type_features'] : array();

if (isset($_GET['orderby'])) {
    unset($orderby);
    $orderby[$_GET['orderby'] . '_clause'] = isset( $_GET['order']) ?  $_GET['order'] : 'ASC';
}    
if (isset( $_GET['features'] )) {
    unset($type_features);
    $type_features = array_filter($_GET['features']);

}
if (isset( $_GET['greed'] )) {
    unset($type_greed);
    $type_greed = array_filter($_GET['greed']);
}
// if (isset( $_GET['min-price']) && strlen($_GET['min-price'])) {
//     $price_range['min'] = (int)$_GET['min-price'];
//     // } else { $price_range['min'] = 0;
// }
// if (isset( $_GET['max-price']) && strlen($_GET['max-price']))  {
//     $price_range['max'] = (int)$_GET['max-price'];
//     // } else { $price_range['max'] = 100000;
// }
// $_SESSION['query_items']['price_range']=$price_range;


$_SESSION['query_items']['orderby']=$orderby;
$_SESSION['query_items']['type_greed']=$type_greed;
$_SESSION['query_items']['type_features']=$type_features;



            
?>
    
                <div class="catalog-content-left">
                <form class="catalog-content-form" action="" method="get">
                    <fieldset>
                        <legend class="catalog-content-title">Стоимость:</legend>
                        <div class="range-filter">
                            <div class="range-controls">
                                <div class="scale">
                                    <div class="bar"></div> <!-- style="margin-left:50px;width:100px;" -->
                                    <div class="toggle min-toggle seekBarToogle"></div>
                                    <div class="toggle max-toggle seekBarToogle2"></div>
                                    
                                </div>
                                
                            </div>
                            <div class="price-controls">
                                <label for="min-p">от</label>
                                <input id="min-p" name="min-price" class="min-price" type="text" placeholder="0"
                                 <?php
                                if ($price_range) {
                                        echo 'value="' . $price_range['min'] . '"';
                                    }    
                                  ?>>
                                <label for="max-p">до</label>
                                <input id="max-p" name="max-price" class="max-price" type="text" placeholder="100000"
                                <?php
                                if ($price_range) {
                                        echo 'value="' . $price_range['max'] . '"';
                                    }    
                                  ?>>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="catalog-content-title">Сетка:</legend>
                        <input type="hidden" name="greed[]" value="">
                        <ul class="radio-buttons">
                            <li>
                                <input type="checkbox" id="r1" class="greed" name="greed[]" value="aдаптивная"
                                 <?php
                                if (in_array('aдаптивная', $type_greed)) {
                                        echo 'checked="checked"';
                                    }    
                                  ?>>
                                <label class="label-radio" for="r1">Адаптивная</label>
                            </li>
                            <li>
                                <input type="checkbox" id="r2" class="greed" name="greed[]" value="фиксированная"
                                <?php
                                if (in_array('фиксированная', $type_greed)) {
                                        echo 'checked="checked"';
                                    }    
                                  ?>>
                                <label class="label-radio" for="r2">Фиксированная</label>
                            </li>
                            <li>
                                <input type="checkbox" id="r3" class="greed" name="greed[]" value="резиновая"
                                <?php
                                if (in_array('резиновая', $type_greed)) {
                                        echo 'checked="checked"';
                                    }    
                                  ?>>
                                <label class="label-radio" for="r3">Резиновая</label>
                            </li>
                        </ul>
                    </fieldset>
                    <fieldset>
                        <legend class="catalog-content-title">Особенности:</legend>
                        <input type="hidden" name="features[]" value="">
                        <ul>
                            <?php
                            $list = array('слайдер' => 'Слайдер',
                                          'блок преимуществ' => 'Блок преимуществ',
                                          'новости' => 'Новости',
                                          'галерея' => 'Галерея',
                                          'корзина' => 'Корзина',
                                           );
                            $id = 1;
                            foreach ($list as $key => $value) { ?>
                                <li>
                                <input type="checkbox" id="<?= 'c' . $id ?>" class="features" name="features[]" value="<?= $key ?>" 
                                <?php
                                if (in_array( $key , $type_features)) {
                                        echo 'checked="checked"';
                                    }    
                                  ?>>
                                <label class="label-checkbox" for="<?= 'c' . $id++ ?>"><?= $value ?></label>
                            </li>
                            <?php
                            }
                            ?>
                            
                        </ul>
                    </fieldset>
                    <button class="btn" type="submit">Показать</button>
                </form>
            </div>

            <div class="catalog-content-right">
                <div class="catalog-content-sort clearfix">
                    <form action="" method="GET" id="filter">
                        <ul class="sort-type">
                            <li>
                                <span>Сортировать:</span>
                            </li>
                            <li>
                                <input id="orderby_1" type="radio" name="orderby" value="price" <?php
                                if (array_key_exists('price_clause', $orderby)) {
                                        echo 'checked="checked"';
                                    }    
                                  ?> />
                                <label for="orderby_1">По цене</label>
                            </li>
                            <li>
                                <input id="orderby_2" type="radio" name="orderby"  value="type" <?php
                                if (array_key_exists('type_clause', $orderby)) {
                                        echo 'checked="checked"';
                                    }    
                                  ?> />
                                <label for="orderby_2">По типу</label>
                            </li>
                            <li>
                                <input id="orderby_3" type="radio" name="orderby" value="features" <?php
                                if (array_key_exists('features_clause', $orderby)) {
                                        echo 'checked="checked"';
                                    } 

                                  ?> />
                                <label for="orderby_3">По функционалу</label>
                            </li>
                        </ul>
                        <ul class="sort-value">
                            <li>
                                <input id="order_1" type="radio" name="order" value="DESC" <?php
                                if (in_array('DESC', $orderby)) {
                                        echo 'checked="checked"';
                                    }    
                                  ?> />
                                <label for="order_1" class="sort-value-down active"></label>
                            </li>
                            <li>
                                <input id="order_2" type="radio" name="order" value="ASC" <?php
                                    if (in_array('ASC', $orderby)) {
                                        echo 'checked="checked"';
                                    }    
                                ?> />
                                <label for="order_2" class="sort-value-up"></label>
                            </li>
                        </ul>
                        <!-- <button style="font-size: 14px">Применить фильтр</button> -->
                    </form>
                </div>

                <div class="catalog-gallery">
                     <?php //if ($_GET && !empty($_GET)) { // если было передано что-то из формы
                        //go_filter(); // запускаем функцию фильтрации
                    //} ?> 

                    <?php

                        // while ( have_posts() ) {
                        //  //die("ура");
                        //  the_post();
                        //  echo '<div style="background-color: blue; color: #000000">';
                        // get_template_part( 'template-parts/content', get_post_format() );
                        //  echo '</div>';
                        // }    

                        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                        $price_clause = array(
                            'key' => 'price',
                            'type' => 'numeric', // тип поля - число
                        );
                        $type_clause = array(
                            'key' => 'type',
                            'compare' => 'EXISTS',
                        );
                        $features_clause = array(
                            'relation' => 'AND',
                        );
                                     
                        if ($type_features) {
                            foreach ($type_features as $key => $value) {
                                $features_clause[] =  array(
                                    'key' => 'features',
                                    'value' => $value,
                                    'compare' => 'LIKE',
                                    );  
                            }
                        }
                        
                        if ($type_greed) {
                            $type_clause['value'] = $type_greed;
                            $type_clause['compare'] = 'IN';
                            $type_clause['type'] = 'CHAR';
                        }
                                            
                        if ($price_range) {
                            $price_clause['value'] = $price_range;
                            // тип сравнения, здесь это BETWEEN - т.е. между "Цены от" и до "Цены до"                            
                            $price_clause['compare'] = 'BETWEEN';
                        }
                        
                        // echo ($_GET['max-price']);
                        // var_dump($_GET['greed']);      
                        // var_dump($type_clause);
                        
                        // var_dump($orderby);
                        // echo ob_get_contents();
                        // die();
                        $args = array('meta_query' => array (
                            'relation' => 'AND',
                            'type_clause' => $type_clause,
                            'price_clause' => $price_clause,
                            'features_clause' => $features_clause,        
                            ),
                                            'posts_per_page' => 2,
                                            'paged' => $paged,
                                            'orderby' => $orderby,
                                    );

                        $_query = new WP_Query($args);
                        while ( $_query->have_posts() ) : $_query->the_post();
                        $meta = get_post_meta( get_the_ID() ); 
                    
                        // if ( array_key_exists('price', $meta) ) {
                    ?>
                    <div class="catalog-gallery-item">
                        <?php the_post_thumbnail(); ?>
                        <div class="gallery-item-active">
                            <p><?php the_title(); ?></p>
                            <p>
                                <?= "{$meta['type'][0]}" ?>
                                <br>
                                <?= "{$meta['features'][0]}" ?>
                            </p>
                            <a class="btn btn-by" href="#"><?= "{$meta['price'][0]}" ?></a>
                        </div>
                    </div>  

                    <?php
                        // }
                        endwhile; // End of the loop.


                        //  wp_reset_postdata();
                        
                        // while ( have_posts() ) {
                        //  the_post();
                        //  echo '<div style="background-color: blue; color: #000000">';
                        // get_template_part( 'template-parts/content', get_post_format() );
                        //  echo '</div>';
                        // }
                        wp_reset_postdata();

                    ?>
                </div><!-- end "catalog-gallery" -->

                <?php if ( $_query->max_num_pages > 1 ) : ?>
                <div class="paginator">

                    <?php 
                        $big = 999999999; // need an unlikely integer

                            echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $_query->max_num_pages,
                        'prev_text' => 'Предыдущая',
                        'next_text' => 'Следующая'
                        ) );
        
                     ?>
                    
                </div> <!-- end "paginator" -->
                <?php endif; ?>
            </div>

        </main><!-- #main -->
    <!-- </div>#primary -->

<?php
//get_sidebar();
get_footer();
