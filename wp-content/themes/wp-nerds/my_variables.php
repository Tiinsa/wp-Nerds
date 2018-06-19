<?php
$js_vars = array(
    'mapParams' => array(
      //  'max_enter' => echo get_theme_mod( 'features_discription_1' );,
    //   'map_x' => 59.9386115,
      'map_x' => echo get_theme_mod( 'map_x' ),
      //  'map_y' => echo get_theme_mod( 'features_discription_1' ),
      //  'map_zoom' => echo get_theme_mod( 'features_discription_1' ),
        //'map_marker_img' => echo get_theme_mod( 'map_marker_image' ),
    )
);
foreach ($js_vars as $var_name => $data) {
    echo "var {$var_name} = ".json_encode($data, JSON_UNESCAPED_UNICODE).";\n";
}