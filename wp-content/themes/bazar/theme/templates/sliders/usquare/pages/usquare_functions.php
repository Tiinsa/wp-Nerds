<?php
function generate_usquare($settings, &$itemsArray, $plugin_url)
{
	
	$settings['item-image-width']=$settings['item-width']/2;
	$settings['item-image-height']=$settings['item-height'];
	
	$count=count($itemsArray);
	if ($count==0) return '';
	if ($count<$settings['usquare-items-per-line']) $settings['usquare-items-per-line']=$count;

	$usquare_width=$settings['usquare-items-per-line']*$settings['item-width'];
	$close_button_left=$settings['item-width']-40;
	$usquare_about_height=$settings['item-extended-height']-75;
	
	$rows=ceil($count/$settings['usquare-items-per-line']);
	$usquare_height=$rows*$settings['item-height'];

$frontHtml = '
<style type="text/css">
.usquare_module_wrapper {
	width: '.$usquare_width.'px;
	height: '.$usquare_height.'px;
}
.usquare_block {
	width: '.$settings['item-width'].'px; 
	height: '.$settings['item-height'].'px; 
}
.usquare_block_extended {
	width: '.$settings['item-width'].'px; 
	height: '.$settings['item-extended-height'].'px; 
	margin-top: '.$settings['item-height'].'px; 
}
.usquare_block_extended .close {
	left: '.$close_button_left.'px;
}
.usquare_block_extended .usquare_about {
	height: '.$usquare_about_height.'px; 
}
</style>';


$frontHtml .='<div class="usquare_module_wrapper usquare_items_' . $settings['usquare-items-per-line'] . '">
		
			<div class="usquare_module_shade"></div>
';


if (count($itemsArray)>0) {
	foreach ($itemsArray as $key => $arr) {
		if (!isset($arr['item-background-color'])) $arr['item-background-color']='#ef4939';
		if ($arr['item-background-color']=='') $arr['item-background-color']='#ef4939';
		if (!isset($arr['item-background-image'])) $arr['item-background-image']='';
		
		$item_style='background-color: '.$arr['item-background-color'].';';
		if ($arr['item-background-image']!='') $item_style='background: url('.$arr['item-background-image'].');';
		
		if (!isset($arr['image-position'])) $arr['image-position']=0;
		
		$image_style='';
		$custom_info_style='';
		$arrow_style='';
		$arrow_image=$plugin_url.'images/arrow-' . ($settings['usquare-arrow'] ? $settings['usquare-arrow'] : 'dark') . '.png';
		$w=$settings['item-image-width'];
		$h=$settings['item-image-height'];
		if ($arr['item-image-position']==2) {$w=$settings['item-width']; $image_style='max-width: 100%; ';}
		$arr['item-image'] = $plugin_url . 'timthumb/timthumb.php?src=' . $arr['item-image'] . '&w='.$w.'&h='.$h;
		
		$image='<img src="'.$arr['item-image'].'" class="usquare_square" alt="" style="'.$image_style.$item_style.' width: '.$w.'px; height: '.$h.'px;" />';

		if ($arr['item-image-position']==1) {
			$custom_info_style=' style="right: 0; text-align: right;"';
			$arrow_style=' style="float: right; padding: 0 0 5px;"';
			$arrow_image=$plugin_url.'images/arrow_r-'. ($settings['usquare-arrow'] ? $settings['usquare-arrow'] : 'dark') .'.png';
		}

$frontHtml .='<div class="usquare_block">';
if ($arr['item-image-position']==0 || $arr['item-image-position']==2) $frontHtml .= $image;
if ($arr['item-image-position']!=2) {
$frontHtml .='				<div class="usquare_square" style="'.$item_style.' width: '.$w.'px; height: '.$h.'px;">
					<div class="usquare_square_text_wrapper"'.$custom_info_style.'>
						<img src="'.$arrow_image.'" class="usquare_arrow" alt="arrow" '.$arrow_style.'>
						<div class="clear"></div>
						<h2>'.$arr['item-title'].'</h2>
						<span>'.$arr['item-description'].'</span>
						<div class="clear"></div>
					</div><!-- usquare_square_wrapper -->
				</div><!--div    usquare_square -->';
}
if ($arr['item-image-position']==1) $frontHtml .= $image;

if( strpos($item_style, 'transparent' ) !== false ) {
	$item_style = 'background-color: #fff';
}

$frontHtml.='
				<div class="usquare_block_extended" style="'.$item_style.'">
					<a href="#" class="close"><img src="'.$plugin_url.'images/close.png" alt="close"/></a>
					<ul class="social_background">';
		if ($arr['item-facebook']!='') $frontHtml .= '<li><a href="'.$arr['item-facebook'].'"><img src="'.$plugin_url.'images/social-fb.png" alt="social" /></a></li>';
		if ($arr['item-twitter']!='') $frontHtml .= '<li><a href="'.$arr['item-twitter'].'"><img src="'.$plugin_url.'images/social-tw.png" alt="social" /></a></li>';
		if ($arr['item-linkedin']!='') $frontHtml .= '<li><a href="'.$arr['item-linkedin'].'"><img src="'.$plugin_url.'images/social-in.png" alt="social" /></a></li>';
		if ($arr['item-pinterest']!='') $frontHtml .= '<li><a href="'.$arr['item-pinterest'].'"><img src="'.$plugin_url.'images/social-pint.png" alt="social" /></a></li>';
		if ($arr['item-yahoo']!='') $frontHtml .= '<li><a href="'.$arr['item-yahoo'].'"><img src="'.$plugin_url.'images/social-yah.png" alt="social" /></a></li>';
		if ($arr['item-digg']!='') $frontHtml .= '<li><a href="'.$arr['item-digg'].'"><img src="'.$plugin_url.'images/social-dig.png" alt="social" /></a></li>';
$frontHtml .=					'</ul>
				
					<div class="clear"></div>
					
					<!--span class="bold">info:</span-->
					<div class="usquare_about">'.$arr['item-content'].'
					</div>
				</div><!-- usquare_block_extended -->
			</div>
';
	}
}
$frontHtml .= '
</div>
<script>
    (function($){
		$(document).ready( function() {
		    $(".usquare_module_wrapper").uSquare({
				opening_speed:		'.$settings['opening-speed'].',
				closing_speed:		'.$settings['closing-speed'].',
				easing:				"'.$settings['easing'].'"
			});
		});
    })(jQuery);
</script>
';
return $frontHtml;
}

function check_timthumb_cache_folder()
{
	global $usquare;
	$p1=substr_count($usquare->path, "/");
	$p2=substr_count($usquare->path, "\\");
	if ($p1>$p2) $slash="/";
	else $slash="\\";
	$folder = $usquare->path.$slash."timthumb".$slash."cache".$slash;
	$file = $folder."test_file.html";
	$handle = @fopen($file, "wb");
	if ($handle==FALSE) {
		echo '<br /><div style="background-color: #decdc6; border: 1px solid #c981c0; padding: 5px; margin-bottom: 5px;"><b>Note:</b> Please make folder &nbsp;&nbsp;<b>'.$folder.'</b>&nbsp;&nbsp; writeable.<br /><a href="http://codex.wordpress.org/Changing_File_Permissions#Using_an_FTP_Client" target="_blank">Here</a> is how to do that.</div>';
		return;
	}
	@fclose($handle);
	@unlink($file);
}

function check_upload_folder()
{
	$upload_dir = wp_upload_dir();
	$path="";
	if (isset($upload_dir['basedir'])) $path = $upload_dir['basedir'];
	if ($path=="" && defined('ABSPATH'))
	{
		$p1=substr_count(ABSPATH, "/");
		$p2=substr_count(ABSPATH, "\\");
		if ($p1>$p2) $slash="/";
		else $slash="\\";
		$path=ABSPATH."wp-content".$slash."uploads";
	}
	if ($path=="")
	{
		echo '<br /><div style="background-color: #decdc6; border: 1px solid #c981c0; padding: 5px; margin-bottom: 5px;"><b>Note:</b> Please make upload folder: <b>/wp-content/uploads</b></div>';
		return;
	}
	$p1=substr_count($path, "/");
	$p2=substr_count($path, "\\");
	if ($p1>$p2) $slash="/";
	else $slash="\\";
	$folder = $path.$slash;
	$file = $folder."test_file.html";
	$handle = @fopen($file, "wb");
	if ($handle==FALSE) {
		echo '<br /><div style="background-color: #decdc6; border: 1px solid #c981c0; padding: 5px; margin-bottom: 5px;"><b>Note:</b> Please make folder &nbsp;&nbsp;<b>'.$folder.'</b>&nbsp;&nbsp; writeable.<br /><a href="http://codex.wordpress.org/Changing_File_Permissions#Using_an_FTP_Client" target="_blank">Here</a> is how to do that.</div>';
		return;
	}
	@fclose($handle);
	@unlink($file);
}
?>