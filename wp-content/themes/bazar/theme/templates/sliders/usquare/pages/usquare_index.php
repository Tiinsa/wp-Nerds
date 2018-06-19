<div class="wrap">
	<h2>uSquares
			<a href="<?php echo admin_url( "admin.php?page=usquare_edit" ); ?>" class="add-new-h2">Add New</a>
	</h2>
<?php

?>


<table class="wp-list-table widefat fixed">
	<thead>
		<tr>
			<th width="5%">ID</th>
			<th width="30%">Name</th>
			<!--th width="60%">Shortcode</th-->
			<th width="20%">Actions</th>					
		</tr>
	</thead>
	
	<tfoot>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<!--th>Shortcode</th-->
			<th>Actions</th>					
		</tr>
	</tfoot>
	
	<tbody>
		<?php 
			global $wpdb;
			$prefix = $wpdb->prefix;

			if( isset($_GET['action']) && $_GET['action'] == 'delete') {
				$wpdb->query('DELETE FROM '. $prefix . 'usquare WHERE id = '.$_GET['id']);
			}
			$usquares = $wpdb->get_results("SELECT * FROM " . $prefix . "usquare ORDER BY id");
			if (count($usquares) == 0) {
				echo '<tr>'.
						 '<td colspan="100%">No uSquares found. Create one!</td>'.
					 '</tr>';
			} else {
				$tname;
				foreach ($usquares as $usquare) {
					$tname = $usquare->name;
					if(!$tname) {
						$tname = 'usquare #' . $usquare->id . ' (untitled)';
					}
					echo '<tr>'.
							'<td>' . $usquare->id . '</td>'.						
							'<td>' . '<a href="' . admin_url('admin.php?page=usquare_edit&id=' . $usquare->id) . '" title="Edit">'.$tname.'</a>' . '</td>'.
							'<!--td> [usquare id="' . $usquare->id . '"]</td-->' .		
							'<td>' . '<a href="' . admin_url('admin.php?page=usquare_edit&id=' . $usquare->id) . '" title="Edit this item">Edit</a> | '.									  
								  '<a href="' . admin_url('admin.php?page=usquare&action=delete&id='  . $usquare->id) . '" title="Delete this item" >Delete</a>'.
							'</td>'.														
						'</tr>';
				}
			}
		?>
		
	</tbody>		 
</table>

<?php
require_once dirname( __FILE__ ) . '/usquare_functions.php';
check_upload_folder();
check_timthumb_cache_folder();
?>
<div style="margin-top:20px;">

<!--
<h2>Step by step:</h2>
<ol>
	<li><h3>Click on "Add New" button</h3></li>
	<li><h3></h3></li>
	<li><h3>Setup your uSquare, save it, and come back here</h3></li>
	<li><h3>Copy "shortcode" from the table above and use it in your post or page (edit it as HTML).<br />(for adding usquare into .php parts of template use it like this "&lt;?php do_shortcode([usquare id="X"]) ?&gt;" where X is id of your uSquare)</h3></li>
</ol>
</div>
-->
</div>
<?php

?>