<?php
/**
 * @package WordPress
 * @subpackage Your Inspiration Themes
 */ 
                              
yit_register_portfolio_style(  $portfolio_type, 'portfolio-' . $portfolio_type, 'css/style.css' );
yit_register_portfolio_script(  $portfolio_type, 'modernizr', 'js/modernizr.js' );
yit_register_portfolio_script(  $portfolio_type, 'jquery-stapel', 'js/jquery.stapel.js' );
yit_register_portfolio_script(  $portfolio_type, 'resize', get_template_directory_uri() .'/theme/assets/js/jquery.resize.js' );


// add the image size
yit_add_image_size( 'thumb_portfolio_fancy', 242, 188, true );

yit_add_portfolio_config( $portfolio_type, array(
	array(
        'name' => __( 'On click', 'yit' ),
        'id' => 'lightbox',
        'type' => 'select',
        'desc' => __( 'Action when click a work', 'yit' ),
        'options' => array(
			'1' => __('Lightbox', 'yit'),
			'0' => __('Link to detail page', 'yit')			
		),
		'std' => '1'
	),
	
	array(
		'type' => 'sep'
	),
	array(
		'type' => 'simple-text',
		'id'   => 'simple_text',
		'desc' => '<h4>' . __('Page detail settings', 'yit') . '</h4>'
	),
    array(
        'name' => __( 'Select detail layout', 'yit' ),
        'id' => 'layout',
        'type' => 'select',
        'desc' => __( 'Show the selected layout in detail page.', 'yit' ),
        'options' => array(
			'small' => __('Small', 'yit'),
			'big' => __('Big', 'yit')			
		),
		'std' => 'small'
	),
	array(
        'name' => __( 'Display Other Projects', 'yit' ),
        'id' => 'display_related',
        'type' => 'onoff',
        'desc' => __( 'Select if you want to show other projects below the item.', 'yit' )
    ),
    array(
        'name' => __( 'Items', 'yit' ),
        'id' => 'detail_nitems',
        'type' => 'number',
        'min' => 0,
        'max' => 200,
        'desc' => __( 'Select the number of items to show below the item. Leave 0 to show all.', 'yit' ),
        'std' => 0
    ),	
    array(
        'name' => __( 'Enable lightbox icon', 'yit' ),
        'id' => 'event_project_lightbox',
        'type' => 'onoff',
        'desc' => __( 'Enable lightbox icon for detail images.', 'yit' ),
	),
    array(
        'name' => __( 'Other Projects label', 'yit' ),
        'id' => 'other_projects_label',
        'type' => 'text',
        'std' =>  __( 'Other Projects', 'yit' ),
        'desc' => __( 'Customize the Other Projects label', 'yit' )
    )
));
