<?php
// iiRe Social Lite Widget - 12-15-2012
class iiReSocialLite extends WP_Widget {

  	function iiReSocialLite()  {
    	$widget_ops = array('classname' => 'iiReSocialLite', 'description' => 'Social Lite Icons for widget' );
    	$this->WP_Widget('iiReSocialLite', 'iiRe Social Lite Icons', $widget_ops);
  	}
 

	function form($instance)  {
    	$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    	$title = $instance['title'];
		?>
  		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>		

		<?php
	}
 

	function update($new_instance, $old_instance) {
    	$instance = $old_instance;
    	$instance['title'] = $new_instance['title'];
    	return $instance;
  	}
 

  	function widget($args, $instance) {
    	extract($args, EXTR_SKIP);

    	$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		
        echo $before_widget;
        if(!empty($title)) {
           echo $before_title.$title.$after_title;
        }
		
		global $wpdb;
		global $blog_id;

		$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social_lite";
	
		$settings = array();		
		$rs = $wpdb->get_results("SELECT * FROM $table_name");
		foreach ($rs as $row) {
			$settings[$row->option_name] = $row->option_value;
		}		
		
		echo '<div id="iire_social_lite_widget" class="iire_social_lite_widget">';
		echo stripslashes($settings['widget_output']);
		echo '</div>';

		echo $after_widget;
  	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("iiReSocialLite");') );
?>