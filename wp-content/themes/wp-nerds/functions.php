<?php
/**
 * wp-Nerds functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp-Nerds
 */

if ( ! function_exists( 'wp_nerds_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wp_nerds_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wp-Nerds, use a find and replace
		 * to change 'wp-nerds' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wp-nerds', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'wp-nerds' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wp_nerds_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'wp_nerds_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_nerds_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wp_nerds_content_width', 640 );
}
add_action( 'after_setup_theme', 'wp_nerds_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_nerds_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wp-nerds' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-nerds' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar 2', 'wp-nerds' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'wp-nerds' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wp_nerds_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wp_nerds_scripts() {
	// подключение стилей
	//wp_enqueue_style( 'wp-nerds-style', get_stylesheet_uri() );

	// подключение стилей
	wp_enqueue_style( 'normalize-style', get_theme_file_uri('css/normalize.css') );
	wp_enqueue_style( 'my-style', get_theme_file_uri('css/my_style.css') );



	wp_enqueue_script( 'wp-nerds-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'wp-nerds-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	//подключение скриптов
	wp_enqueue_script('jquery');
	//wp_enqueue_script( 'wp-nerds-my-variables', get_template_directory_uri() . '/my_variables.php', array(), null, true );
	wp_enqueue_script( 'wp-nerds-map-api', 'https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyAOelhnqKXLp86XJrRuvflHNKuiKv8fMYs', array(), null, true );
	wp_enqueue_script( 'wp-nerds-my-js', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true );
	//wp_enqueue_script( 'wp-nerds-my-js', get_template_directory_uri() . '/js/sort.js'. get_template_directory_uri(), array('jquery'), null, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_nerds_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

//отключение расстановки тегов параграфов start 
remove_filter('the_content', 'wpautop');     //записи
remove_filter('the_excerpt', 'wpautop');     //цитаты
remove_filter('comment_text', 'wpautop');    //комментарии
//отключение расстановки тегов параграфов end

//отключение типографских замен start 
remove_filter('the_content', 'wptexturize');     //записи
remove_filter('the_excerpt', 'wptexturize');     //цитаты
remove_filter('comment_text', 'wptexturize');    //комментарии
//отключение типографских замен end

//отключение форматирования слова WordPress start 
remove_filter('the_content', 'capital_P_dangit',11);    //записи
remove_filter('the_excerpt', 'capital_P_dangit',11);    //цитаты
remove_filter('comment_text', 'capital_P_dangit',31);   //комментарии
//отключение форматирования слова WordPress end

//***********Удалить id 
add_filter('nav_menu_item_id', 'remove_nav_menu_item_id');

function remove_nav_menu_item_id($id) { 
	return "";
};

//********Заменить class
add_filter('nav_menu_css_class','remove_nav_menu_classes');

function remove_nav_menu_classes($classes) { 
	if ( in_array("current-menu-item", $classes ) ) { 
		// unset( $classes );
		// $classes[0]= 'parent item active';
		$classes = str_replace('current-menu-item', 'active', $classes);
	// } else { 
	// 	$classes = array();
	// 	$classes[0]= '';
	} 
	return $classes;
};




/*** Удаляем id и class из кода меню ***/
// add_filter('nav_menu_css_class', 'ydalit_atribyti_y_li', 100, 1);
// add_filter('nav_menu_item_id', 'ydalit_atribyti_y_li', 100, 1);
// add_filter('page_css_class', 'ydalit_atribyti_y_li', 100, 1);
// function ydalit_atribyti_y_li($peremennnya) {
//     if (is_array($peremennnya)) :
//         return
//             array_intersect($peremennnya, array('current-menu-item'));
//     else : return '';
//     endif;
// }

// function replace_menu_css_class($text) {
//   $my_classes = array(
//     'menu-item' => '',
//     'page_item' => '',
//     '-type-custom'=>'',
//     '-object-custom'=>'',
//     '-home'=>'',
//     '-type-post_type'=>'',
//     '-object-page'=>'',
//     '-has-children'=>'page-has-children',
//     'current-page-ancestor'=>'',
//     'current-menu-ancestor'=>'',
//     'current_page_parent'=>'current_parent',
//     'current-menu-parent'=>'',
//     'current_page_ancestor'=>'current_ancestor',
//     '-type-custom'=>'',
//     '-object-custom'=>'',
//     'current-'=> 'current-page',
    
// );
//   $text = str_replace(array_keys($my_classes), $my_classes, $text);
//   return $text;
// }
// add_filter( 'nav_menu_css_class', 'replace_menu_css_class' );



function themename_custom_header_setup() {
    $defaults = array(
        // Default Header Image to display
        'default-image'         => get_template_directory_uri() . '/images/headers/default.jpg',
        // Display the header text along with the image
        'header-text'           => true,
        // Header text color default
        'default-text-color'        => '000',
        // Header image width (in pixels)
        'width'             => 1000,
        // Header image height (in pixels)
        'height'            => 198,
        // Header image random rotation default
        'random-default'        => false,
        // Enable upload of image file in admin 
        'uploads'       => false,
        // function to be called in theme head section
        'wp-head-callback'      => 'wphead_cb',
        //  function to be called in preview page head section
        'admin-head-callback'       => 'adminhead_cb',
        // function to produce preview markup in the admin screen
        'admin-preview-callback'    => 'adminpreview_cb',
        );
}
add_action( 'after_setup_theme', 'themename_custom_header_setup' );



function themename_post_formats_setup() {
    add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
}
add_action( 'after_setup_theme', 'themename_post_formats_setup' );





function themename_custom_post_formats_setup() {
    // add post-formats to post_type 'page'
    add_post_type_support( 'page', 'post-formats' );
 
    // add post-formats to post_type 'my_custom_post_type'
    add_post_type_support( 'my_custom_post_type', 'post-formats' );
}
add_action( 'init', 'themename_custom_post_formats_setup' );

// настройка кастомайзера - добавление изменения цвета линков

function tcx_register_theme_customizer( $wp_customize ) {
 
    $wp_customize->add_setting(
        'tcx_link_color',
        array(
            'default'     => '#000000'
        )
    );
 
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_color',
            array(
                'label'      => __( 'Link Color', 'tcx' ),
                'section'    => 'colors',
                'settings'   => 'tcx_link_color'
            )
        )
    );
 
}
add_action( 'customize_register', 'tcx_register_theme_customizer' );

function tcx_customizer_css() {
    ?>
    <style type="text/css">
        a { color: <?php echo get_theme_mod( 'tcx_link_color' ); ?>; }
    </style>
    <?php
}
add_action( 'wp_head', 'tcx_customizer_css' );

// настройка кастомайзера - добавление редактирования слайдеров.

function tcx_register_wp_nerds_slider( $wp_customize ) {

	$wp_customize->add_panel( 'panel_slider', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Header Slider Panel', 'textdomain' ),
	    'description' => __( 'Description of what this panel does.', 'textdomain' ),
	) );

//******************* section 1

    $wp_customize->add_section(
    'tcx_slide_1_options',
    array(
        'title'     => 'Slide 1 Options',
        'priority'  => 201,
        'panel' => 'panel_slider',
    )
);

    $wp_customize->add_setting(
    'tcx_slider_image1',
    array(
        'default'      => '',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
        $wp_customize,
        'tcx_slider_image1',
	        array(
	            'label'    => 'Slider Image 1',
	            'settings' => 'tcx_slider_image1',
	            'section'  => 'tcx_slide_1_options'
	        )
    	)
    );

    $wp_customize->add_setting(
    'tcx_slider_title_1',
    array(
        'default'      => 'Долго, дорого, скрупулёзно.',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'tcx_slider_title_1',
	        array(
	            'label'    => 'Slider Title 1',
	            'settings' => 'tcx_slider_title_1',
	            'section'  => 'tcx_slide_1_options'
	        )
    	)
    );

    $wp_customize->add_setting(
    'tcx_slider_discription_1',
    array(
        'default'      => 'Математически выверенный дизайн для вашего сайта или мобильного приложения',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'tcx_slider_discription_1',
	        array(
	            'label'    => __( 'Slider Discription 1', 'textdomain' ),
	            'settings' => 'tcx_slider_discription_1',
	            'section'  => 'tcx_slide_1_options',
	            'type' => 'textarea',
	        )
    	)
    );

//************************* section 2

    $wp_customize->add_section(
    'tcx_slide_2_options',
    array(
        'title'     => 'Slide 2 Options',
        'priority'  => 201,
        'panel' => 'panel_slider',
    )
);

    $wp_customize->add_setting(
    'tcx_slider_image2',
    array(
        'default'      => '',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
        $wp_customize,
        'tcx_slider_image2',
	        array(
	            'label'    => 'Slider Image 2',
	            'settings' => 'tcx_slider_image2',
	            'section'  => 'tcx_slide_2_options'
	        )
    	)
    );

$wp_customize->add_setting(
    'tcx_slider_title_2',
    array(
        'default'      => 'Любите ли вы математику, как любим её мы?',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'tcx_slider_title_2',
	        array(
	            'label'    => 'Slider Title 2',
	            'settings' => 'tcx_slider_title_2',
	            'section'  => 'tcx_slide_2_options'
	        )
    	)
    );

    $wp_customize->add_setting(
    'tcx_slider_discription_2',
    array(
        'default'      => 'Нашим дизайнерам мы удаляем нейроны, ответственные <br>
                                        за креатив, что бы дать им возможность все просчитать',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'tcx_slider_discription_2',
	        array(
	            'label'    => __( 'Slider Discription 2', 'textdomain' ),
	            'settings' => 'tcx_slider_discription_2',
	            'section'  => 'tcx_slide_2_options',
	            'type' => 'textarea',
	        )
    	)
    );    

//****************** section 3 

    $wp_customize->add_section(
    'tcx_slide_3_options',
    array(
        'title'     => 'Slide 3 Options',
        'priority'  => 201,
        'panel' => 'panel_slider',
    )
);

    $wp_customize->add_setting(
    'tcx_slider_image3',
    array(
        'default'      => '',
        'transport'    => 'refresh'
    )
);
 	$wp_customize->add_control(
        new WP_Customize_Image_Control(
        $wp_customize,
        'tcx_slider_image3',
	        array(
	            'label'    => 'Slider Image 3',
	            'settings' => 'tcx_slider_image3',
	            'section'  => 'tcx_slide_3_options'
	        )
    	)
    );
$wp_customize->add_setting(
    'tcx_slider_title_3',
    array(
        'default'      => 'Только наркотики, только хардкор!',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'tcx_slider_title_3',
	        array(
	            'label'    => 'Slider Title 3',
	            'settings' => 'tcx_slider_title_3',
	            'section'  => 'tcx_slide_3_options'
	        )
    	)
    );

    $wp_customize->add_setting(
    'tcx_slider_discription_3',
    array(
        'default'      => 'Все дизайнерские решения в нашей компании принимаются <br>
                                        только под воздействием качественных галюциногенов',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'tcx_slider_discription_3',
	        array(
	            'label'    => __( 'Slider Discription 3', 'textdomain' ),
	            'settings' => 'tcx_slider_discription_3',
	            'section'  => 'tcx_slide_3_options',
	            'type' => 'textarea',
	        )
    	)
    );    
   
 
}
add_action( 'customize_register', 'tcx_register_wp_nerds_slider' );

// настройка панелей для преимуществ (features)

function register_wp_nerds_features( $wp_customize ) {

	$wp_customize->add_panel( 'panel_features', array(
	    'priority' => 11,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Features Panel', 'textdomain' ),
	    'description' => __( 'Description of what this panel does.', 'textdomain' ),
	) );

//******************* section 1

    $wp_customize->add_section(
    'features_1_options',
    array(
        'title'     => 'Features 1 Options',
        'priority'  => 201,
        'panel' => 'panel_features',
    )
);

    $wp_customize->add_setting(
    'features_image_1',
    array(
        'default'      => '',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
        $wp_customize,
        'features_image_1',
	        array(
	            'label'    => 'Features Image 1',
	            'settings' => 'features_image_1',
	            'section'  => 'features_1_options'
	        )
    	)
    );

    $wp_customize->add_setting(
    'features_title_1',
    array(
        'default'      => 'Веб-сайты',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'features_title_1',
	        array(
	            'label'    => 'Features Title 1',
	            'settings' => 'features_title_1',
	            'section'  => 'features_1_options'
	        )
    	)
    );

    $wp_customize->add_setting(
    'features_discription_1',
    array(
        'default'      => 'Мир никогда не будет прежним после того как увидит ваш сайт!',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'features_discription_1',
	        array(
	            'label'    => __( 'Features Discription 1', 'textdomain' ),
	            'settings' => 'features_discription_1',
	            'section'  => 'features_1_options',
	            'type' => 'textarea',
	        )
    	)
    );

//************************* section 2

    $wp_customize->add_section(
    'features_2_options',
    array(
        'title'     => 'Features 2 Options',
        'priority'  => 201,
        'panel' => 'panel_features',
    )
);

    $wp_customize->add_setting(
    'features_image_2',
    array(
        'default'      => '',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
        $wp_customize,
        'features_image_2',
	        array(
	            'label'    => 'Features Image 2',
	            'settings' => 'features_image_2',
	            'section'  => 'features_2_options'
	        )
    	)
    );

$wp_customize->add_setting(
    'features_title_2',
    array(
        'default'      => 'Приложения',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'features_title_2',
	        array(
	            'label'    => 'Features Title 2',
	            'settings' => 'features_title_2',
	            'section'  => 'features_2_options'
	        )
    	)
    );

    $wp_customize->add_setting(
    'features_discription_2',
    array(
        'default'      => 'Покорите топ-10 приложений в AppStore и Google Play!',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'features_discription_2',
	        array(
	            'label'    => __( 'Features Discription 2', 'textdomain' ),
	            'settings' => 'features_discription_2',
	            'section'  => 'features_2_options',
	            'type' => 'textarea',
	        )
    	)
    );    

//****************** section 3 

    $wp_customize->add_section(
    'features_3_options',
    array(
        'title'     => 'Features 3 Options',
        'priority'  => 201,
        'panel' => 'panel_features',
    )
);

    $wp_customize->add_setting(
    'features_image_3',
    array(
        'default'      => '',
        'transport'    => 'refresh'
    )
);
 	$wp_customize->add_control(
        new WP_Customize_Image_Control(
        $wp_customize,
        'features_image_3',
	        array(
	            'label'    => 'Features Image 3',
	            'settings' => 'features_image_3',
	            'section'  => 'features_3_options'
	        )
    	)
    );
$wp_customize->add_setting(
    'features_title_3',
    array(
        'default'      => 'Презентации',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'features_title_3',
	        array(
	            'label'    => 'Features Title 3',
	            'settings' => 'features_title_3',
	            'section'  => 'features_3_options'
	        )
    	)
    );

    $wp_customize->add_setting(
    'features_discription_3',
    array(
        'default'      => 'Вы даже не подозреваете, насколько вы изумительны!',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'features_discription_3',
	        array(
	            'label'    => __( 'Features Discription 3', 'textdomain' ),
	            'settings' => 'features_discription_3',
	            'section'  => 'features_3_options',
	            'type' => 'textarea',
	        )
    	)
    );    
   
 
}
add_action( 'customize_register', 'register_wp_nerds_features' );


//ввод параметров карты

function register_wp_nerds_map( $wp_customize ) {

    $wp_customize->add_section(
    'map_panel',
    array(
        'title'     => 'Map Panel',
        'priority'  => 15,
    
    )
);

//     $wp_customize->add_setting(
//     'map_coords',
//     array(
//         'default'      => '59.9386115',
//         'transport'    => 'refresh'
//     )
// );
    // $wp_customize->add_control(
    // 	new WP_Customize_Control(
    //     $wp_customize,
    //     'map_coords',
	   //      array(
	   //          'label'    => 'Map Coords',
	   //          'settings' => 'map_coords',
	   //          'section' => 'map_panel'
	   //      )
    // 	)
    // );

 $wp_customize->add_setting(
    'map_x_coords',
    array(
        'default'      => '59.9386115',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
    	new WP_Customize_Control(
        $wp_customize,
        'map_x_coords',
	        array(
	            'label'    => 'Map X',
	            'settings' => 'map_x_coords',
	            'section' => 'map_panel'
	        )
    	)
    );

    $wp_customize->add_setting(
    'map_y_coords',
    array(
        'default'      => '30.3235393',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
    	new WP_Customize_Control(
        $wp_customize,
        'map_y_coords',
	        array(
	            'label'    => 'Map Y',
	            'settings' => 'map_y_coords',
	            'section' => 'map_panel'
	        )
    	)
    );

 $wp_customize->add_setting(
    'map_zoom',
    array(
        'default'      => '16',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
    	new WP_Customize_Control(
        $wp_customize,
        'map_zoom',
	        array(
	            'label'    => 'Map Zoom',
	            'settings' => 'map_zoom',
	            'section' => 'map_panel'
	        )
    	)
    );

    $wp_customize->add_setting(
    'map_marker_image',
    array(
        'default'      => '',
        'transport'    => 'refresh'
    )
);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
        $wp_customize,
        'map_marker_image',
	        array(
	            'label'    => 'Map Marker Image',
	            'settings' => 'map_marker_image',
	            'section' => 'map_panel'
	        )
    	)
    );
}

add_action( 'customize_register', 'register_wp_nerds_map' );



function map_customizer_js() {
?>
    <script>
       	var x = <?php echo get_theme_mod( 'map_x_coords' ); ?>;
        var y = <?php echo get_theme_mod( 'map_y_coords' ); ?>;
        var map_zoom = <?php echo get_theme_mod( 'map_zoom' ); ?>;
        var map_image = '<?php echo get_theme_mod( 'map_marker_image' ); ?>';
<?php
	    if( is_customize_preview() ){
	    ?>
	    	var draggable = true;
	    <?php
	    	} else { 
	    ?>
	           	var draggable = false;
	    <?php
	    	}
        ?>
    </script>
<?php
}
add_action( 'wp_head', 'map_customizer_js' );



function customizer_panel() {
?>
	<script>
      	window.onload = function() {
       		console.log ("enter");
			if (wp.customize.section) {
				console.log ('parent');
				window.addEventListener('message', function(e){
				// if (!(e.data.action  == "iframe" || e.data.action == "setMapsCoords")) {
				// 	// console.log(e.origin, e.data);
				// 	console.log ('return');
				// 	return;
				// }
				if ( e.data.action == "setMapsCoords" && !(e.data.lat || e.data.lng)) {
					wp.customize.section( 'map_panel' ).focus();
					} else if (e.data.action == "setMapsCoords" && (e.data.lat || e.data.lng)) {
					wp.customize.section( 'map_panel' ).focus();
					document.getElementById('_customize-input-map_x_coords').value = e.data.lat;
					document.getElementById('_customize-input-map_y_coords').value = e.data.lng;
					$( "#_customize-input-map_x_coords" ).trigger( "change" );
					$( "#_customize-input-map_y_coords" ).trigger( "change" );
					} else if (e.data.action  == "slide-one") {
						wp.customize.section( 'tcx_slide_1_options' ).focus();
					} else if (e.data.action  == "slide-two") {
						wp.customize.section( 'tcx_slide_2_options' ).focus();
					} else if (e.data.action  == "slide-three") {
						wp.customize.section( 'tcx_slide_3_options' ).focus();
					} else if (e.data.action  == "features-one") {
						wp.customize.section( 'features_1_options' ).focus();
					} else if (e.data.action  == "features-two") {
						wp.customize.section( 'features_2_options' ).focus();
					} else if (e.data.action  == "features-three") {
						wp.customize.section( 'features_3_options' ).focus();
					}; 
				return;
				
						
						// if (e.data.action  == "iframe") {
						// 	console.log ('mymess handler', e);
							

						// 	var iframe = document.getElementsByTagName('iframe')[0];
							
	    		//	var markerBounce = iframe.contentWindow.document.querySelector(".footer-maps__preview");
	    		// 			markerBounce.addEventListener('click', function(event){
							// 	console.log ('is_customize_preview function.php',wp.customize.section( 'map_panel' ));
							// 	wp.customize.section( 'map_panel' ).focus();
								
							// });
							

							// var slides = iframe.contentWindow.document.querySelector('.slider');
							// slides.addEventListener('click', function(event){
							// 	console.log ('slides');
								
							// 	wp.customize.panel( 'panel_slider' ).focus();
							// 	console.log (event.target.value);
							// 	if (event.target.value == 'slide-one') {
							// 		wp.customize.section( 'tcx_slide_1_options' ).focus();
							// 	} else if (event.target.value == 'slide-two') {
							// 		wp.customize.section( 'tcx_slide_2_options' ).focus();
							// 	} else if (event.target.value == 'slide-three') {
							// 		wp.customize.section( 'tcx_slide_3_options' ).focus();
							// 	} else {
							// 		return;
							// 	}
								
						// 	// });
						// 	return true;
						// };
				}, false);
			}
				// if (!wp.customize.section) {
				// 	console.log ('iframe');
				// 	console.log ('mymess event', parent);
				// 	// parent.postMessage({iframe: true, action : "iframe"},'http://wp-nerds:8080');
				// }
		};
    </script>
<?php
}

add_action( 'customize_controls_init', 'customizer_panel' );

// if( is_customize_preview() ){
// 	add_action( 'customize_register', 'customizer_panel' );
// }


function customize_preview () {
?>
	<script type="text/javascript">
		window.onload = function(){
			var slides = document.querySelector('.slider');
	        slides.addEventListener('click', function(event){
	        	var target = event.target;
	            while (target.tagName != 'BUTTON' && target != this && target) {
	            	if (target.classList.contains('btn_map')) {
				      // нашли элемент, который нас интересует!
	                	return;
				    }
				    target = target.parentNode;
	            }
	            if (target.value == 'slide-one') {
	                parent.postMessage({action : "slide-one"},'http://wp-nerds:8080');
	            } else if (target.value == 'slide-two') {
	                parent.postMessage({action : "slide-two"},'http://wp-nerds:8080');
	            } else if (target.value == 'slide-three') {
	                parent.postMessage({action : "slide-three"},'http://wp-nerds:8080');
	            } else {
	                return;
	            };
	        });

			var btnMapMap = document.querySelector('.btn_map--map');
			btnMapMap.addEventListener('click', function(event){
				parent.postMessage({action : "setMapsCoords"},'http://wp-nerds:8080');
	        });

	        var features = document.querySelector('.features');
	        features.addEventListener('click', function(event){
	        	var target = event.target;
	            while (target.tagName != 'BUTTON' && target != this && target) {
	            	if (target.classList.contains('btn_map--features')) {
				      // нашли элемент, который нас интересует!
	                	return;
				    }
				    target = target.parentNode;
	            }
	            
	            if (target.value == 'features-one') {
	                parent.postMessage({action : "features-one"},'http://wp-nerds:8080');
	            } else if (target.value == 'features-two') {
	            	parent.postMessage({action : "features-two"},'http://wp-nerds:8080');
	            } else if (target.value == 'features-three') {
	            	parent.postMessage({action : "features-three"},'http://wp-nerds:8080');
	            } else {
	                return;
	            };
	        });
		};	
	</script>
<?php 
}	

add_action( 'customize_preview_init', 'customize_preview' );




add_action( 'init', 'do_session_start' ); 
 
function do_session_start() { 
    if ( !session_id() ) session_start(); 
}



function initSliderPoint()
{	
	if(session_id() == '') {
		session_start();
	}

	if (!isset($_SESSION['query_items'])) {
	 	$_SESSION['query_items'] = array();
	}

	$price_range = isset($_SESSION['query_items']['price_range']) 
		? $_SESSION['query_items']['price_range'] 
		: array('min'    => 0,'max' => 100000);
	

	if (isset( $_GET['min-price']) && strlen($_GET['min-price'])) {
    	$price_range['min'] = (int)$_GET['min-price'];
	}
	if (isset( $_GET['max-price']) && strlen($_GET['max-price']))  {
	    $price_range['max'] = (int)$_GET['max-price'];
	}

	$_SESSION['query_items']['price_range']=$price_range;
	?>
	<script>
		var editor = document.querySelector('.range-controls');
		if (editor) {

		    var element = '.scale';
		    var elementObj1 = document.querySelector(element);
		    var slider1 = new SliderPoint(element, 0, 100000,<?= $price_range['min'] ?> , <?= $price_range['max'] ?>);
		    slider1.init();
			
		};
	</script>
	<?php

}
add_action( 'wp_head', 'initSliderPoint' );


