<?php
////////////////////////////////////////////////////////////////////
// PhP Code Widget
////////////////////////////////////////////////////////////////////
class PHP_Code_Widget extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'widget_execphp', 'description' => __('Arbitrary text, HTML, or PHP Code', 'vanderstrap'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('execphp', __('PHP Code Widget', 'vanderstrap'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$text = apply_filters( 'widget_execphp', $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
			ob_start();
			eval('?>'.$text);
			$text = ob_get_contents();
			ob_end_clean();
			?>
			<div class="execphpwidget"><?php echo $instance['filter'] ? wpautop($text) : $text; ?></div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( $new_instance['text'] ) );
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = format_to_edit($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'vanderstrap'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs.', 'vanderweb4'); ?></label></p>
<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("PHP_Code_Widget");'));

////////////////////////////////////////////////////////////////////
// Spacer Widget
////////////////////////////////////////////////////////////////////
class spacerwidget extends WP_Widget {
     
	function __construct() {
		$widget_ops = array( 'classname' => 'spacer-widget', 'description' => __('A Empty Spacer Module without content', 'vanderstrap') );
		$control_ops = array( 'width' => 450, 'height' => 250, 'id_base' => 'spacerwidget' );
		parent::__construct('spacerwidget', __('Spacer Widget', 'vanderstrap'), $widget_ops, $control_ops);
	}
	
	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );

		echo $before_widget;

		echo $after_widget;
	}
     
    function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}
	
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'vanderstrap'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
	}
} //end class
function spacerwidget_load() { register_widget( 'spacerwidget' ); } /* Function that registers our widget. */
add_action( 'widgets_init', 'spacerwidget_load' ); /* Add our function to the widgets_init hook. */

////////////////////////////////////////////////////////////////////
// Shortcode Widget
////////////////////////////////////////////////////////////////////
class vanderstrapshortcodewidget extends WP_Widget {
     
	function __construct() {
		$widget_ops = array( 'classname' => 'vanderweb_shortcode_widget', 'description' => __('Shortcode Wiget', 'vanderstrap') );
		$control_ops = array( 'width' => 450, 'height' => 250, 'id_base' => 'vanderstrapshortcodewidget' );
		parent::__construct('vanderstrapshortcodewidget', __('Shortcode Widget', 'vanderstrap'), $widget_ops, $control_ops);
	}
	
	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$text = apply_filters( 'vanderstrap_shortcode_widget', $instance['text'], $instance );
		echo $before_widget;
		
		echo do_shortcode($text);
		
		echo $after_widget;
	}
     
    function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);

		return $instance;
	}
	
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = strip_tags($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'vanderstrap'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Shortcode:', 'vanderstrap'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>" /></p>
<?php
	}
} //end class
function vanderstrapshortcodewidget_load() { register_widget( 'vanderstrapshortcodewidget' ); } /* Function that registers our widget. */
add_action( 'widgets_init', 'vanderstrapshortcodewidget_load' ); /* Add our function to the widgets_init hook. */