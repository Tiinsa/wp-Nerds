<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Дизайн студия «Nёrd's»</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:500,700&amp;subset=cyrillic" rel="stylesheet">

        <?php wp_head(); ?>
        <!-- <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory')?>/css/normalize.css">
         <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory')?>/css/my_style.css"> -->
    </head>
    <body>
        <header class="main-header">
            <div class="conteiner">
                <div class="main-header-content clearfix">
                    <div class="index-logo">
                        <img src="<?php bloginfo('template_directory')?>/img/index-logo-1.png" width="139" height="56" alt="Дизайн студия «Nёrd's»">
                    </div>
                    <!-- <nav class="main-navigation"> -->

					<?php wp_nav_menu( array(
						'theme_location'  => '',
						'menu'            => '',
						'container'       => 'nav',
						'container_class' => 'main-navigation',
						'container_id'    => '',
						'menu_class'      => '',
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => '',
					) ); ?>

                        <!-- <ul>
                            <li>
                                <a href="#">Студия</a>
                            </li>
                            <li>
                                <a href="#">Клиенты</a>
                            </li>
                            <li>
                                <a href="catalog.html">Магазин</a>
                            </li>
                            <li>
                                <a href="#">Контакты</a>
                            </li>
                            <li class="active">
                                <a class="cart" href="#">Корзина</a>
                            </li>
                        </ul> -->
                    <!-- </nav> -->
                </div>

				<div id="sidebar" class="sidebar">
    				<?php //dynamic_sidebar(); ?>
				</div>

				
				<?php 
    			//	if (is_home() || is_front_page()) {
        		//		echo do_shortcode("[metaslider id=84]"); 
    			//	}
				?>	
					

				<?php	
					if (is_home() || is_front_page()) {
						get_template_part( 'header', 'slider' );
						
					}
				?>	
                
            </div>
        </header>
        
<main class="conteiner clearfix">        