<?php
add_action( 'widgets_init', 'recent_post_with_content' );
function recent_post_with_content() 
{
	register_widget( 'Widget_Recent_Content' );
}
class Widget_Recent_Content extends WP_Widget 
{
	function Widget_Recent_Content() 
	{
		$widget_ops = array('classname' => 'widget-blog grid_6', 'description' => __( 'Recent Post With Content','framework') );
		$this->WP_Widget('recent_post_content', __('Recent Post with Content','framework'), $widget_ops);
	}
	function widget( $args, $instance ) 
	{
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'From the blog','framework' ) : $instance['title'], $instance, $this->id_base);
		$number = apply_filters('widget_number', empty( $instance['number'] ) ? __( '1','framework' ) : $instance['number'], $instance, $this->id_base);
		$rpost_query = array('post_type'=>'post','posts_per_page' => $number); 
		$rpost_posts = new WP_Query();
		$rpost_posts->query($rpost_query);
		echo $before_widget;
			if ( $title)
			{
				echo '<h4 class="widget-title">' . $title . '</h4><ul>';
			}
				if ($rpost_posts->have_posts()) 
				{ 
					while ($rpost_posts->have_posts()) : $rpost_posts->the_post();
					echo '<p><strong><a href="'.get_permalink().'">'.get_the_title().'</a></strong></p>';
					echo '<p><span>'.get_the_time('F d, Y').' . ';
					comments_popup_link(__('No Comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework'));
					echo '</span></p>';
					limited_content(30);
					endwhile; 
				} wp_reset_query(); echo '</ul>';
			echo $after_widget;
	}
	function update( $new_instance, $old_instance ) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;
	}
	function form( $instance ) 
	{
		$title = esc_attr( $instance['title'] );
		$number = esc_attr( $instance['number'] ); ?>
    	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:','framework'); ?></label> <input class="widefat" 
        id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
    	<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Posts to show:','framework'); ?></label> <input class="widefat" 
        id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" style="WIDTH: 52px; HEIGHT: 25px;"  
        size=5 value="<?php echo $number; ?>" /></p>
	<?php } 
} ?>