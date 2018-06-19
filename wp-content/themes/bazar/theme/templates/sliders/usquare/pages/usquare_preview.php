<?php 
$title = '';
require_once dirname( __FILE__ ) . '/usquare_settings.php';

foreach(explode('||',$tsettings) as $val) {
	$expl = explode('::',$val);
	$settings[$expl[0]] = $expl[1];
	$settings[$expl[0]] = str_replace('#|#|', '||', $settings[$expl[0]]);
	$settings[$expl[0]] = str_replace('#:#:', '::', $settings[$expl[0]]);
}

if ($titems != '') {
	$explode = explode('||',$titems);
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
$buf=generate_usquare($settings, $itemsArray, $this->url);
$usquare_width=$settings['usquare-items-per-line']*$settings['item-width'];

echo '<div style="width: '.$usquare_width.'px; position: relative; margin: 0 auto;">'.$buf.'</div>';
?>