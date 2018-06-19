<?php   
/*
Plugin Name: uSquare
Plugin URI: http://ww.shindiristudio.com/usquare-wp/
Description: HTML grid for items
Author: br0
Version: 1.0
Author URI: http://www.shindiristudio.com/
*/

global $usquare;
if (!class_exists("usquareAdmin")) {
	require_once dirname( __FILE__ ) . '/usquare_class.php';	
	$usquare = new usquareAdmin (__FILE__);
}

?>