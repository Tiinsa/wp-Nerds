<?php

class faq_filters extends WP_Widget
{
    function faq_filters() 
    {
        $widget_ops = array( 
            'classname' => 'faq-filters', 
            'description' => __('Get list of portfolio categories, created on portfolio custom type.', 'yit') 
        );

        $control_ops = array( 'id_base' => 'faq-filters' );
        $this->WP_Widget( 'faq-filters', 'Faq Filters', $widget_ops, $control_ops );

    }

    function form( $instance )
    {
        $defaults = array( 
            'title' => 'Faq Filters',
            'project_post_type' => 0
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p><label>
            <strong><?php _e( 'Widget Title', 'yit' ) ?>:</strong><br />
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
        </label></p>
        <?php
    }

    function widget( $args, $instance )
    {                                                
        extract( $args );

        $title = apply_filters('widget_title', $instance['title'] );     
        $project_post_types = isset( $instance['project_post_type']) ? $instance['project_post_type'] : 0;
        echo $before_widget.'<div class="border">';
        echo $before_title . $title . $after_title;
		
		?>
		<!--<p><a href="#all" data-option-value="*" class="all active"><?php _e('View all', 'yit') ?></a> <?php _e('or filter by:', 'yit') ?></p>-->
		<p><?php _e('filter by:', 'yit') ?></p>
		<?php

		$faq = new WP_Query( "post_type=faq" );
		$cat = get_categories( "taxonomy=category-faq&title_li=" );
	
		$allicon = yit_get_option('faq-allcategories-url');
	
	    if( !$faq->have_posts() ) return false ?>
			<ul>
				<li><img src="<?php echo $allicon ? $allicon : YIT_IMAGES_URL . '/faq/all.png'; ?>" /><a href="#all" data-option-value="*" class="active">ALL</a></li>
				<?php foreach ($cat as $c) :
				
					$thumbnail_id = get_metadata( 'faq_term', $c->term_id, 'thumbnail_id', true );
					$image = wp_get_attachment_url( $thumbnail_id );
					
					echo '<li><img src="'. $image . '" /><a href="#' . $c->slug . '" data-option-value=".' . $c->slug . '">' . $c->name . '</a></li>';			
				endforeach ?>
			</ul>
		<?php



        echo '</div>'.$after_widget;
    }

    function update( $new_instance, $old_instance ) 
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['project_post_type'] = $new_instance['project_post_type'];
        return $instance;
    }
}     

?>