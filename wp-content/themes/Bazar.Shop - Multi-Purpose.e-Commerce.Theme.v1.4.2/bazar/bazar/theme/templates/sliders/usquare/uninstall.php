<?php 
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
	exit();

global $wpdb;
$usquare_table = $wpdb->prefix . 'usquare';
$wpdb->query( "DROP TABLE $usquare_table" );

?>