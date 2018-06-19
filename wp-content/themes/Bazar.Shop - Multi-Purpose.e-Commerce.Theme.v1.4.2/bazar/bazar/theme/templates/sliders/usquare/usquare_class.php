<?php
class usquareAdmin {
	
	var $main, $path, $name, $url;
	
	function __construct($file) {
		$this->main = $file;
		$this->init();
		return $this;
	}
	
	function init() {
		$this->path = dirname( __FILE__ );
		$this->name = basename( $this->path );
		$this->url = YIT_USQUARE_URL . '/'; //plugins_url( "/{$this->name}/" );
		if( is_admin() ) {
			
			//register_activation_hook( $this->main , array(&$this, 'activate') );
			$this->activate();
			
			add_action('admin_menu', array(&$this, 'admin_menu')); 
			
			// Ajax calls
			add_theme_support( 'post-thumbnails' );
			add_action('wp_ajax_usquare_save', array(&$this, 'ajax_save'));  
			add_action('wp_ajax_usquare_preview', array(&$this, 'ajax_preview'));
			add_action('wp_ajax_usquare_post_search', array(&$this, 'ajax_post_search'));
			add_action('wp_ajax_usquare_post_get', array(&$this, 'ajax_post_get'));
			add_action('wp_ajax_usquare_post_category_get', array(&$this, 'ajax_post_category_get'));
			
		}
		else {
			add_action('wp', array(&$this, 'frontend_includes'));
			add_shortcode('usquare', array(&$this, 'shortcode') );
		}
	}
	
	function activate() {
		global $wpdb;
	
		$table_name = $wpdb->prefix . 'usquare';
	
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$royal_sliders_sql = "CREATE TABLE " . $table_name ." (
						  id mediumint(9) NOT NULL AUTO_INCREMENT,
						  name tinytext NOT NULL,
						  settings text NOT NULL,
						  items text NOT NULL,
						  PRIMARY KEY (id)
						);";	
	
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($royal_sliders_sql);			
		}
	
	}	
	
	function admin_menu() {
		$ctmenu = add_menu_page( 'uSquare', 'uSquare', 'manage_options', 'usquare', array(&$this, 'admin_page'));
		$submenu = add_submenu_page( 'usquare', 'uSquare', 'Add New', 'manage_options', 'usquare_edit', array(&$this, 'admin_edit_page'));
		
		add_action('load-'.$ctmenu, array(&$this, 'admin_menu_scripts')); 
		add_action('load-'.$submenu, array(&$this, 'admin_menu_scripts')); 
		add_action('load-'.$ctmenu, array(&$this, 'admin_menu_styles')); 
		add_action('load-'.$submenu, array(&$this, 'admin_menu_styles')); 
	}
	
	function admin_menu_scripts() {
		wp_enqueue_script('post');
		wp_enqueue_script('farbtastic');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('usquare-admin-js', $this->url . 'js/usquare_admin.js' );
		wp_enqueue_script('jQuery-easing', $this->url . 'js/frontend/jquery.easing.1.3.js' );
		wp_enqueue_script('jQuery-usquare', $this->url . 'js/frontend/jquery.usquare.js' );
		
		wp_enqueue_script('jQuery-ui', $this->url . 'js/frontend/jquery-ui-1.9.1.min.js' );
		wp_enqueue_script('jQuery-mousew', $this->url . 'js/frontend/jquery.mousewheel.min.js' );
		wp_enqueue_script('jQuery-customScroll', $this->url . 'js/frontend/jquery.mCustomScrollbar.min.js' );			
	}
	
	function admin_menu_styles() {
		wp_enqueue_style('farbtastic');	
		wp_enqueue_style('thickbox');
		wp_enqueue_style( 'usquare-admin-css', $this->url . 'css/usquare_admin.css' );
		wp_enqueue_style( 'usquare-thick-css', $this->url . 'css/thickbox.css' );
		wp_enqueue_style( 'usquare-css', $this->url . 'css/frontend/usquare_style.css' );
		wp_enqueue_style( 'customScroll-css', $this->url . 'css/frontend/jquery.mCustomScrollbar.css' );	
		wp_enqueue_style( 'customfont1', $this->url . 'fonts/ostrich%20sans/stylesheet.css' );
		wp_enqueue_style( 'customfont2', $this->url . 'fonts/PT%20sans/stylesheet.css' );
	}

	function frontend_includes() {
        return;
		wp_enqueue_script('jquery');
		wp_enqueue_script('jQuery-easing', $this->url . 'js/frontend/jquery.easing.1.3.js' );
		wp_enqueue_script('jQuery-usquare', $this->url . 'js/frontend/jquery.usquare.js' );
		wp_enqueue_script('jQuery-mousew', $this->url . 'js/frontend/jquery.mousewheel.min.js' );
		wp_enqueue_script('jQuery-customScroll', $this->url . 'js/frontend/jquery.mCustomScrollbar.min.js' );
		wp_enqueue_script('jQuery-ui', $this->url . 'js/frontend/jquery-ui-1.9.1.min.js' );

		wp_enqueue_style( 'usquare-css', $this->url . 'css/frontend/usquare_style.css' );
		wp_enqueue_style( 'customScroll-css', $this->url . 'css/frontend/jquery.mCustomScrollbar.css' );
		wp_enqueue_style( 'customfont1', $this->url . 'fonts/ostrich%20sans/stylesheet.css' );
		wp_enqueue_style( 'customfont2', $this->url . 'fonts/PT%20sans/stylesheet.css' );

	}

	function ajax_save() {
		$id = false;
		$settings = '';
		$items = '';
		foreach( $_POST as $key => $value) {
			if ($key != 'action') {
				if ($key == 'usquare_id'){
					if ($value != '') {
						$id = (int)$value;
					}
				}
				else if ($key == 'usquare_title'){
					$name = stripslashes($value);
				}
				else if(strpos($key,'sort') === 0){
					$value=str_replace('||', '#|#|', $value);
					$value=str_replace('::', '#:#:', $value);
					$items .= $key . '::' . stripslashes($value) . '||';
				}
				else {
					$value=str_replace('||', '#|#|', $value);
					$value=str_replace('::', '#:#:', $value);
					$settings .= $key . '::' . stripslashes($value) . '||';
				}
			}
		}
		if ($items != '') $items = substr($items,0,-2);
		if ($settings != '') $settings = substr($settings,0,-2);
		global $wpdb;
		$table_name = $wpdb->prefix . 'usquare';
		if($id) {	
			$wpdb->update(
				$table_name,
				array(
					'name'=>$name,
					'settings'=>$settings,
					'items'=>$items),
				array( 'id' => $id ),
				array( 
					'%s',
					'%s',
					'%s'),
				array('%d')
			);
		}
		else {
			$wpdb->insert(
				$table_name,
				array(
					'name'=>$name,
					'settings'=>$settings,
					'items'=>$items),	
				array(
					'%s',
					'%s',
					'%s')						
				
			);
			$id = $wpdb->insert_id;
		}
		
			
		echo $id;
		die();
	}
	
	function ajax_preview() {
		$tid = false;
		$tsettings = '';
		$titems = '';
		foreach( $_POST as $key => $value) {
			if ($key != 'action') {
				if ($key == 'usquare_id'){
					if ($value != '') {
						$tid = (int)$value;
					}
				}
				else if ($key == 'usquare_title'){
					$tname = $value;
				}
				else if(strpos($key,'sort') === 0){
					$value=str_replace('||', '#|#|', $value);
					$value=str_replace('::', '#:#:', $value);
					$titems .= $key . '::' . $value . '||';
				}
				else {
					$value=str_replace('||', '#|#|', $value);
					$value=str_replace('::', '#:#:', $value);
					$tsettings .= $key . '::' . $value . '||';
				}
			}
		}
		if ($titems != '') $titems = substr($titems,0,-2);
		if ($tsettings != '') $tsettings = substr($tsettings,0,-2);
		
		include_once($this->path . '/pages/usquare_preview.php');
		
		die();
	}
	
	function ajax_post_search(){
		if(isset($_POST['query']) && !empty($_POST['query'])){
			$searchVal = strtolower($_POST['query']);
		}
		else {
			$searchVal = '';
		}
		
		$query_args = array( 'posts_per_page' => -1, 'post_type' => 'any');
		$query = new WP_Query( $query_args );
		
		foreach ( $query->posts as $match) {
			if($searchVal != ''){
				if(strpos(strtolower($match->post_name), $searchVal) !== false){
					$thumbn = wp_get_attachment_image_src( get_post_thumbnail_id($match->ID) , 'full');
					echo '<li><a href="'.$match->ID.'"><img style="margin-right:5px;" src="'.$this->url.'timthumb/timthumb.php?src='.$thumbn[0].'&w=150&h=150" width="32" height="32" alt="" /><span class="usquarePostCompleteName">'.$match->post_title .'</span><span class="clear"></span></a></li>';
				}
			}
		}
		die();
	}
	
	function ajax_post_get($post_id = false){
		$id = (int) $_POST['post_id'];
		if ($post_id) $id = $post_id;
		$post = get_post($id); 

		echo $post->post_title . '||';
		echo substr($post->post_date, 8, 2) . '/' . substr($post->post_date, 5, 2) . '/' . substr($post->post_date, 0, 4) . '||';
		$post_categories = get_the_category( $id );
		
		echo $post_categories[0]->name . '||';
		$excerpt = $post->post_excerpt;
		if ($excerpt == '' && $post->post_content != '') {
			//echo substr($post->post_content,0,100) . '...';
			echo $post->post_content;
		}
		
		echo $excerpt . '||';
		if ( has_post_thumbnail($id)) {
			echo wp_get_attachment_url( get_post_thumbnail_id($id , 'full'));
		}
		echo '||' . $post->post_content;

		if(!$post_id) {
			die();
		}
		
	}
	
	function ajax_post_category_get() {
		$cat_name = $_POST['cat_name'];
		$term = get_term_by('name', $cat_name, 'category');
		$cat_id = $term->term_id;
		
		$the_query = new WP_Query( array( 'cat' => $cat_id, 'post_type' => 'any', 'posts_per_page'=>-1, 'order' => 'ASC'));
		$start = true;
		while ( $the_query->have_posts() ) : $the_query->the_post();
			if ($the_query->post->post_type != 'page') {
				if (!$start) {
					echo '||';
				}
				$start = false;
				$this->ajax_post_get($the_query->post->ID);
			}
		endwhile;

		die();
	}
	
		
	function admin_page() {
		include_once($this->path . '/pages/usquare_index.php');
	}
	
	function admin_edit_page() {
		include_once($this->path . '/pages/usquare_edit.php');
	}
	
	function shortcode($atts) {
		extract(shortcode_atts(array(
			'id' => ''
		), $atts));
		
		include_once($this->path . '/pages/usquare_frontend.php');
		$frontHtml = preg_replace('/\s+/', ' ',$frontHtml);

		return do_shortcode($frontHtml);
	}
}
?>