<?php
add_action( 'widgets_init', 'recent_post_with_detail' );
function recent_post_with_detail() 
{
	register_widget( 'Widget_Recent_Post' );
}
class Widget_Recent_Post extends WP_Widget 
{
	function Widget_Recent_Post() 
	{
		$widget_ops = array('classname' => 'Widget_Recent_Post', 'description' => __( 'Recent Post','framework') );
		$this->WP_Widget('recent_post', __('Recent Post with Detail','framework'), $widget_ops);
	}
	function widget( $args, $instance ) 
	{
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Recent Post','framework' ) : $instance['title'], $instance, $this->id_base);
		$number = apply_filters('widget_number', empty( $instance['number'] ) ? __( '4','framework' ) : $instance['number'], $instance, $this->id_base);
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
				echo '<li><span><a href="'.get_permalink().'">'.get_the_title().'</a></span>';
				_e(' Posted by ','framework');
				the_author_posts_link();
				echo _e(' on ','framework');
				echo get_the_time('M d, Y').'</li>';
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