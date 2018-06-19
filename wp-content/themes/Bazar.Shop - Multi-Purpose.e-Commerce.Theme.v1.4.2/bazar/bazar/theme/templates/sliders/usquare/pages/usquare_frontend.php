<?php 

require_once dirname( __FILE__ ) . '/usquare_settings.php';
global $wpdb;
if($id) {
	global $wpdb;
	$usquare = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usquare WHERE id='.$id);
	$usquare = $usquare[0];
}

$title = $usquare->name;

foreach(explode('||',$usquare->settings) as $val) {
	$expl = explode('::',$val);
	if(substr($expl[0], 0, 8) == 'cat-name') {
	}
	else {
		$settings[$expl[0]] = $expl[1];
		$settings[$expl[0]] = str_replace('#|#|', '||', $settings[$expl[0]]);
		$settings[$expl[0]] = str_replace('#:#:', '::', $settings[$expl[0]]);
	}
	
}

if ($usquare->items != '') {
	$explode = explode('||',$usquare->items);

	$itemsArray = array();
	foreach ($explode as $it) {
		$ex2 = explode('::', $it);
		$key = substr($ex2[0],0,strpos($ex2[0],'-'));
		$subkey = substr($ex2[0],strpos($ex2[0],'-')+1);
		$itemsArray[$key][$subkey] = $ex2[1];
		$itemsArray[$key][$subkey] = str_replace('#|#|', '||', $itemsArray[$key][$subkey]);
		$itemsArray[$key][$subkey] = str_replace('#:#:', '::', $itemsArray[$key][$subkey]);
	}
}

require_once dirname( __FILE__ ) . '/usquare_functions.php';
$frontHtml=generate_usquare($settings, $itemsArray, $this->url);
?>