<?php
add_action( 'widgets_init', 'flickr_widget' );
function flickr_widget() 
{
	register_widget( 'Widget_flickr' );
}
class Widget_flickr extends WP_Widget 
{
	function Widget_flickr() 
	{
		$widget_ops = array('classname' => 'widget-flickr grid_5', 'description' => __( 'Flickr Photos','framework') );
		$this->WP_Widget('widget_flickr', __('Flickr Widget','framework'), $widget_ops);
	} 
	function widget( $args, $instance ) 
	{
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Flickr Widget','framework' ) : $instance['title'], $instance, $this->id_base);
		$flickr_id = apply_filters('widget_flickr_id', empty( $instance['flickr_id'] ) ? __( '86321243@N04','framework' ) : $instance['flickr_id'], $instance, $this->id_base);
		$number = apply_filters('widget_number', empty( $instance['number'] ) ? __( '6','framework' ) : $instance['number'], $instance, $this->id_base);
		$width = apply_filters('widget_width', empty( $instance['width'] ) ? __( '70','framework' ) : $instance['width'], $instance, $this->id_base);
		$flickr_tags = apply_filters('widget_tags', empty( $instance['tags'] ) ? __( '','framework' ) : $instance['tags'], $instance, $this->id_base);
		echo $before_widget;
		if ( $title)
		{ 
		$sn=0;
		echo '<h4 class="widget-title">' . $title . '</h4><ul>'; 
		} ?>
		<div id="flickr-images">
		<script type="text/javascript">
		jQuery(document).ready(function($) 
		{
			$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id=<?php echo $flickr_id; ?>&display=latest&tags=<?php echo $flickr_tags; ?>
			&tagmode=any&format=json&jsoncallback=?", function(data) 
			{
				var target = "#flickr-images";
				for (i = 0; i <= <?php echo $number; ?> - 1; i = i + 1 ) 
				{
					var pic = data.items[i];
					var liNumber = i + 1;
					var hifimgwidth = "<?php echo $width; ?>";
					$(target).append("<li class='flickr-image no-" + liNumber + "'><a title='" + pic.title + "' href='" + pic.link + "' target='_blank'><img width='" + 
					hifimgwidth + "' src='" + pic.media.m.replace('_m','_s') + "' /></a></li>"); 
				} 
			});
		});
		</script>
		</div>
		<?php 
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);
		$instance['number'] = absint($new_instance['number']);
		$instance['width'] = absint($new_instance['width']);
		$instance['tags'] = strip_tags($new_instance['tags']);
		return $new_instance;
	}
	function form( $instance ) 
	{
		$title = esc_attr( $instance['title'] );
		$flickr_id = esc_attr( $instance['flickr_id'] );
		$number = esc_attr( $instance['number'] );
		$width = esc_attr( $instance['width'] );
		$flickr_tags = esc_attr( $instance['tags'] ); ?>
    	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:','framework'); ?></label> <input class="widefat" 
        id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>    
    	<p><label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID:', 'framework') ?> (<a href="http://idgettr.com/" target="_blank">idGettr</a>)</label>
    	<label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('','framework'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" 		name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" /></p>
    	<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Photos to show:','framework'); ?></label> <input class="widefat" 
        id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" style="WIDTH: 52px; HEIGHT: 25px;"  
        size=5 value="<?php echo $number; ?>" /></p>
    	<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:','framework'); ?></label> <input class="widefat" 
        id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" style="WIDTH: 52px; HEIGHT: 25px;"  
        size=5 value="<?php echo $width; ?>" /></p>
    	<p><label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e('Flickr Tags with comma seprated:','framework'); ?></label> <input class="widefat" 
        id="<?php echo $this->get_field_id('tags'); ?>" name="<?php echo $this->get_field_name('tags'); ?>" type="text" value="<?php echo $flickr_tags; ?>" /></p>
	<?php } 
} ?>