<div class="wrap">
	<?php 
	global $usquare;
	
	$title = '';
	require_once dirname( __FILE__ ) . '/usquare_settings.php';
	global $wpdb;
	if(isset($_GET['id'])) {
		global $wpdb;
		$usquare = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usquare WHERE id='.$_GET['id']);
		$usquare = $usquare[0];
		$pageName = 'Edit uSquare';
	}
	else {
		$pageName = 'New uSquare';
	}
	$title = $usquare->name;
	
	if( isset($usquare->settings) ) {
		foreach(explode('||',$usquare->settings) as $val) {
			$expl = explode('::',$val);
			$settings[$expl[0]] = $expl[1];
			$settings[$expl[0]] = str_replace('#|#|', '||', $settings[$expl[0]]);
			$settings[$expl[0]] = str_replace('#:#:', '::', $settings[$expl[0]]);
		}
	}

	$settings['item-image-width']=$settings['item-width']/2;
	$settings['item-image-height']=$settings['item-height'];
	?>
	
	
	<input type="hidden" id="plugin-url" value="<?php echo $this->url; ?>"/>
	<h2><?php echo $pageName; ?>
		<a href="<?php echo admin_url( "admin.php?page=usquare" ); ?>" class="add-new-h2">Cancel</a>
	</h2>
	
	<div class="form_result"></div>
	<form name="post_form"  method="post" id="post_form">
	<input type="hidden" name="usquare_id" id="usquare_id" value="<?php if(isset($_GET['id']) ) echo $_GET['id']; ?>" />
	<div id="poststuf">
	
		<div id="post-body" class="metabox-holder columns-2" style="margin-right:300px; padding:0;">
		
			<div id="post-body-content">
				<div id="titlediv">
					<div id="titlewrap">
						<label class="hide-if-no-js" style="visibility:hidden" id="title-prompt-text" for="title">Enter name here</label>
						<input type="text" name="usquare_title" size="30" tabindex="1" value="<?php echo $title; ?>" id="title" autocomplete="off" />
					</div>
				</div>
				<h2 class="alignleft" style="padding:0 0 10px 0;">Items</h2>
				<a id="tsort-add-new" class="alignleft button button-highlighted" style="display:block; padding:3px 15px; margin:4px 10px;" href="#">+ Add new item</a>
				<a id="tsort-add-new2" class="alignleft button button-highlighted" style="display:block; padding:3px 15px; margin:4px 10px;" href="#">+ Add new from post</a>
				<a id="tsort-add-new3" class="alignleft button button-highlighted" style="display:block; padding:3px 15px; margin:4px 10px;" href="#">+ Add new from category</a>
				<div class="clear"></div>
				<ul id="usquare-sortable">
				<?php 
				if (isset($usquare->items) && $usquare->items != '') {
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
					
					foreach ($itemsArray as $key => $arr) {
						$num = substr($key,4);
						if (!isset($arr['item-background-color'])) $arr['item-background-color']='transparent';
						if ($arr['item-background-color']=='') $arr['item-background-color']='transparent';
						
						if (!isset($arr['item-background-image'])) $arr['item-background-image']='';
						
						if (!isset($arr['item-image-position'])) $arr['item-image-position']=0;
					?>
					<li id="<?php echo $key; ?>" class="sortableItem">
						<div class="tsort-plus">+</div>
						<div class="tsort-header">Item <?php echo $num; ?> <small><i>- <?php echo $arr['item-title']; ?></i></small> &nbsp;<a href="#" class="tsort-delete"><i>delete</i></a></div>
						<div class="tsort-content">
							<div class="tsort-content-left">
								<table class="fields-group">
									<tr class="field-row">
										<td style="width: 130px;">
											<label for="<?php echo $key; ?>-item-title">Title:</label>
										</td>
										<td style="width: auto;">
											<input name="<?php echo $key; ?>-item-title" value="<?php echo $arr['item-title']; ?>" type="text"  />
										</td>
									</tr>
									<tr class="field-row">
										<td style="width: 130px;">
											<label for="<?php echo $key; ?>-item-description">Description:</label>
										</td>
										<td style="width: auto;">
											<input name="<?php echo $key; ?>-item-description" value="<?php echo $arr['item-description']; ?>" type="text" />
										</td>
									</tr>
									<tr class="field-row">
										<td style="width: 130px;">
											<label>Image:</label>
										</td>
										<td>
											<div class="tsort-image">
												<img id="<?php echo $key; ?>-item-image" src="<?php echo(($arr['item-image'] != '') ? $this->url . '/timthumb/timthumb.php?src=' . $arr['item-image'] . '&w=180&h=125' : $this->url . 'images/no_image.jpg'); ?>" width="180" height="125" /><a href="#" id="<?php echo $key; ?>-item-image-change" class="tsort-change">Change</a>
												<input id="<?php echo $key; ?>-item-image-input" name="<?php echo $key; ?>-item-image" type="hidden" value="<?php echo $arr['item-image']; ?>" />
												<a href="#" id="<?php echo $key; ?>-item-image-remove" class="tsort-remove">Remove</a>
											</div>
										</td>
									</tr>
									<tr class="field-row">
										<td style="width: 130px;">
											<label for="<?php echo $key; ?>-item-content">Content:</label>
										</td>
										<td>
											<textarea class="tsort-contarea" name="<?php echo $key; ?>-item-content"><?php echo $arr['item-content']; ?></textarea>
										</td>
									</tr>
								</table>
							</div>
							<div class="tsort-content-right">
								<table class="fields-group">
									<tr class="field-row">
										<td style="width: 130px;">
											<span class="usquare-help">? <span class="usquare-tooltip">Color of background</span></span>
											<label for="background-color">Background color:</label>
										</td>
										<td style="width: auto;">
											<input id="<?php echo $key; ?>-item-background-color" name="<?php echo $key; ?>-item-background-color" value="<?php echo $arr['item-background-color']; ?>" type="text" style="background:<?php echo $arr['item-background-color']; ?>;">	
											<div class="cw-color-picker-holder" style="left:-70px;">
												<div id="<?php echo $key; ?>-item-background-color-picker" class="cw-color-picker" rel="<?php echo $key; ?>-item-background-color"></div>
											</div>
										</td>
									</tr>
									<tr class="field-row">
										<td style="width: 130px;">
											<label for="background-image">Background image:</label>
										</td>
										<td style="width: auto;">
											<div class="tsort-image" style="height: 50px; width:216px;"><img id="<?php echo $key; ?>-item-background-image" src="<?php echo(($arr['item-background-image'] != '') ? $this->url . '/timthumb/timthumb.php?src=' . $arr['item-background-image'] . '&w=180&h=50' : $this->url . 'images/no_image2.jpg'); ?>" width="180" height="50" /><a href="#" id="<?php echo $key; ?>-item-background-image-change" class="tsort-change" style="left:175px;">Change</a>
											<input id="<?php echo $key; ?>-item-background-image-input" name="<?php echo $key; ?>-item-background-image" type="hidden" value="<?php echo $arr['item-background-image']; ?>" />
											<a href="#" id="<?php echo $key; ?>-item-background-image-remove" class="tsort-remove">Remove</a></div>
										</td>
									</tr>
									
									<tr class="field-row">
										<td style="width: 130px;">
											<label for="image-position">Image position:</label>
										</td>
										<td style="width: auto;">
											<select name="<?php echo $key; ?>-item-image-position">
												<option value="0"<?php if ($arr['item-image-position']==0) echo ' selected="selected"'; ?>>Left</option>
												<option value="1"<?php if ($arr['item-image-position']==1) echo ' selected="selected"'; ?>>Right</option>
												<option value="2"<?php if ($arr['item-image-position']==2) echo ' selected="selected"'; ?>>Full space</option>
											</select>
										</td>
									</tr>
									
									<tr class="field-row">
										<td style="width: 130px;">
											<span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>
											<label for="facebook">Facebook:</label>
										</td>
										<td style="width: auto;">
											<input name="<?php echo $key; ?>-item-facebook" value="<?php echo $arr['item-facebook']; ?>" type="text"  />
										</td>
									</tr>
									<tr class="field-row">
										<td style="width: 130px;">
											<span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>
											<label for="twitter">Twitter:</label>
										</td>
										<td style="width: auto;">
											<input name="<?php echo $key; ?>-item-twitter" value="<?php echo $arr['item-twitter']; ?>" type="text"  />
										</td>
									</tr>
									<tr class="field-row">
										<td style="width: 130px;">
											<span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>
											<label for="linkedin">LinkedIn:</label>
										</td>
										<td style="width: auto;">
											<input name="<?php echo $key; ?>-item-linkedin" value="<?php echo $arr['item-linkedin']; ?>" type="text"  />
										</td>
									</tr>
									<tr class="field-row">
										<td style="width: 130px;">
											<span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>
											<label for="pinterest">Pinterest:</label>
										</td>
										<td style="width: auto;">
											<input name="<?php echo $key; ?>-item-pinterest" value="<?php echo $arr['item-pinterest']; ?>" type="text"  />
										</td>
									</tr>
									<tr class="field-row">
										<td style="width: 130px;">
											<span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>
											<label for="yahoo">Yahoo:</label>
										</td>
										<td style="width: auto;">
											<input name="<?php echo $key; ?>-item-yahoo" value="<?php echo $arr['item-yahoo']; ?>" type="text"  />
										</td>
									</tr>
									<tr class="field-row">
										<td style="width: 130px;">
											<span class="usquare-help">? <span class="usquare-tooltip">Leave it empty if there is no social account for this item</span></span>
											<label for="digg">Digg:</label>
										</td>
										<td style="width: auto;">
											<input name="<?php echo $key; ?>-item-digg" value="<?php echo $arr['item-digg']; ?>" type="text"  />
										</td>
									</tr>
								</table>
							</div>
							<div class="clear"></div>
						</div>
					</li>
					
					<?php 	
					}
				} ?>
				
				</ul>
				<div class="clear"></div>
				
				<div id="style_preview">
				
				
				</div>
			
			</div>
		
			<div id="postbox-container-1" class="postbox-container">
				<div class="postbox">
					<h3 class='hndle' style="cursor:auto"><span>Publish</span></h3>
					<div class="inside">
						<div id="save-progress" class="waiting ajax-saved" style="background-image: url(<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>)" ></div>
						<input name="preview-usquare" id="preview-usquare" value="Preview" class="button button-highlighted" style="padding:3px 25px" type="submit" />
						<input name="save-usquare" id="save-usquare" value="Save uSquare" class="alignright button button-primary" style="padding:3px 15px" type="submit" />
						<img id="save-loader" src="<?php echo $this->url; ?>images/ajax-loader.gif" class="alignright" />
						<br class="clear" />		
					</div>
				</div>
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					
					
					<div id="bla1" class="postbox" >
						<div class="handlediv" title="Click to toggle"><br /></div>
						<h3 class='hndle'><span>General Options</span></h3>
						<div class="inside">
							<table class="fields-group misc-pub-section">						
							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Transition speed (default 300px).</span></span>
									<label for="scroll-speed">Opening Speed</label>
								</td>
								<td>
									<input id="opening-speed" name="opening-speed" value="<?php echo $settings['opening-speed']; ?>" size="5" type="text">	
									<span class="unit">ms</span>
								</td>				
							</tr>
							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Transition speed (default 500px).</span></span>
									<label for="scroll-speed">Closing Speed</label>
								</td>
								<td>
									<input id="closing-speed" name="closing-speed" value="<?php echo $settings['closing-speed']; ?>" size="5" type="text">	
									<span class="unit">ms</span>
								</td>				
							</tr>
							
							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Transition easing function (default 'easeOutSine').</span></span>
									<label for="easing" >Easing</label>
								</td>
								<td>
									<select name="easing">
										<?php 
											$easingArray = array('swing', 'linear', 'easeInQuad', 'easeOutQuad','easeInOutQuad','easeInCubic','easeOutCubic','easeInOutCubic','easeInQuart','easeOutQuart','easeInOutQuart','easeInQuint','easeOutQuint','easeInOutQuint','easeInSine','easeOutSine','easeInOutSine','easeInExpo','easeOutExpo','easeInOutExpo','easeInCirc','easeOutCirc','easeInOutCirc','easeInElastic','easeOutElastic','easeInOutElastic','easeInBack','easeOutBack','easeInOutBack','easeInBounce','easeOutBounce','easeInOutBounce');
											foreach ($easingArray as $item) {
												echo '
										<option value="'.$item.'" '.(($item == $settings['easing']) ? 'selected="selected"' : '').'>'.$item.'</option>';
											}
											
										?>
										
									</select>
								</td>				
							</tr>
							
							
							
							</table>
						</div>
					</div><!-- /GENERAL OPTIONS -->

					<div id="bla2" class="postbox" >
						<div class="handlediv" title="Click to toggle"><br /></div>
						<h3 class='hndle'><span>Global Options</span></h3>
						<div class="inside">
							<table class="fields-group misc-pub-section">	
							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Style for the arrow.</span></span>
									<label for="usquare-arrow" >Arrow style</label>
								</td>
								<td>
									<select id="usquare-arrow" name="usquare-arrow">
										<option value="light" <?php if( isset($settings['usquare-arrow']) ) selected($settings['usquare-arrow'], 'light') ?>>Light</option>
										<option value="dark" <?php if( isset($settings['usquare-arrow']) ) selected($settings['usquare-arrow'], 'dark') ?>>Dark</option>
									</select>
								</td>				
							</tr>
							
							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Number of items per row (default 2).</span></span>
									<label for="usquare-items-per-line" >Items per row</label>
								</td>
								<td>
									<select id="usquare-items-per-line" name="usquare-items-per-line">
										<option value="3" <?php selected($settings['usquare-items-per-line'], 3) ?>>3</option>
										<option value="4" <?php selected($settings['usquare-items-per-line'], 4) ?>>4</option>
									</select>
								</td>				
							</tr>
							</table>
						</div>
					</div><!-- /GLOBAL STYLING OPTIONS -->
					
					
					
					
					
					
					<div id="bla3" class="postbox" >
						<div class="handlediv" title="Click to toggle"><br /></div>
						<h3 class='hndle'><span>Item Styling Options</span></h3>
						<div class="inside">
							<table class="fields-group misc-pub-section">			
							
							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Width of items (default 320px).</span></span>
									<label for="item-width">Width</label>
								</td>
								<td>
									<input id="item-width" name="item-width"  readonly="readonly" value="<?php echo $settings['item-width']; ?>" size="5" type="text">	
									<span class="unit">px</span>
								</td>				
							</tr>
							
							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Height of items (default 160px).</span></span>
									<label for="item-height">Height</label>
								</td>
								<td>
									<input id="item-height" name="item-height"  readonly="readonly" value="<?php echo $settings['item-height']; ?>" size="5" type="text">	
									<span class="unit">px</span>
								</td>				
							</tr>

							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Height of extended part of item (default 320px).</span></span>
									<label for="item-extended-height">Extended height</label>
								</td>
								<td>
									<input id="item-extended-height" name="item-extended-height"  readonly="readonly" value="<?php echo $settings['item-extended-height']; ?>" size="5" type="text">	
									<span class="unit">px</span>
								</td>				
							</tr>

							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Width of image is always half of item width.</span></span>
									<label for="item-image-width">Image width</label>
								</td>
								<td>
									<input id="item-image-width" name="item-image-width" value="<?php echo $settings['item-image-width']; ?>" size="5" type="text" readonly="readonly">	
									<span class="unit">px</span>
								</td>				
							</tr>

							<tr class="field-row">
								<td>
									<span class="usquare-help">? <span class="usquare-tooltip">Height of image is always as item height.</span></span>
									<label for="item-image-height">Image height</label>
								</td>
								<td>
									<input id="item-image-height" name="item-image-height" value="<?php echo $settings['item-image-height']; ?>" size="5" type="text" readonly="readonly">	
									<span class="unit">px</span>
								</td>				
							</tr>

							</table>
						</div>
					</div><!-- /ITEM STYLING OPTIONS -->

				</div>
			</div>
			
			<div id="postbox-container-2" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable"></div>
			</div>
			
			<br class="clear"/>
			
		</div>
	
	</div>
<?php
									$post_types=get_post_types('','names'); 
									$categories = array();
									foreach ($post_types as $post_type ) {
										if (!in_array($post_type, array('page', 'attachment', 'revision', 'nav_menu_item'))) {
									  		$newCats = get_categories(array('type' => $post_type));
											foreach ($newCats as $post_cat) {
												if (!in_array($post_cat, $categories)) {
													array_push($categories, $post_cat); 
												}
											}
										}
									}  
									$catString = '';
									foreach ($categories as $category) {
										$catString .= $category->name . '||';
									}
										if($catString != '') {
										echo '<input type="hidden" id="categories-hidden" value="'.substr($catString,0,strlen($catString)-2).'" />';
									}
?>
	</form>
<?php
require_once dirname( __FILE__ ) . '/usquare_functions.php';
check_upload_folder();
//check_timthumb_cache_folder();
?>

<div style="margin-top:20px;">

<h2>Step by step:</h2>
<ol>
	<li><h3>Enter some name for this uSquare, something associative (name will not be shown on page)</h3></li>
	<li><h3>Add items</h3></li>
	<li><h3><a href="#" class="save_link">Save</a> and go to uSquare <a href="<?php echo admin_url( "admin.php?page=usquare" ); ?>">module main page</a></h3></li>
</ol>
</div>
</div>
<script>
(function($){
/*
function calculate_image_size()
{
	var n=$('#usquare-items-per-line').val();
	var w=$('#item-width').val();
	var h=$('#item-height').val();
	
	$('#item-image-width').val(w/2);
	$('#item-image-height').val(h);
}

$('#usquare-items-per-line').on('change keyup', function() {calculate_image_size();});
*/

function calculate_image_size() {}

$('#usquare-items-per-line').on('change', function(){
	var dimensions = {
		'3' : [ 390, 195, 195, 195, 195 ],
		'4' : [ 290, 145, 145, 145, 145 ]
	};
	var value = $(this).val();
	
	var inputs = $('#bla3 input[type="text"]');
	inputs.each(function(i,v){
		
		$(this).val( dimensions[value][i] );
		
	})
}).change();


$('#item-width').on('change keyup', function() {calculate_image_size();});
$('#item-height').on('change keyup', function() {calculate_image_size();});
$('.save_link').on('click', function() {$('#save-usquare').click();});
})(jQuery);
</script>