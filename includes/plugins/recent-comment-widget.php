<?php
add_action( 'widgets_init', 'recent_comment_with_pdetails' );
function recent_comment_with_pdetails() 
{
	register_widget( 'Widget_Recent_Comments' );
}
class Widget_Recent_Comments extends WP_Widget 
{
	function Widget_Recent_Comments() 
	{
		$widget_ops = array('classname' => 'Widget_Recent_Comments', 'description' => __( 'Recent Comments with Post Details','framework') );
		$this->WP_Widget('recent_comments', __('Recent Comments with Post Details','framework'), $widget_ops);
	}
	function widget( $args, $instance ) 
	{
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Recent Comments','framework' ) : $instance['title'], $instance, $this->id_base);
		$number = apply_filters('widget_number', empty( $instance['number'] ) ? __( '5','framework' ) : $instance['number'], $instance, $this->id_base);
		echo $before_widget;
		if ( $title )
		{
			echo '<h4 class="widget-title">' . $title . '</h4><ul>';
		}
		$comments = get_comments(array('post_type'=>'post')); $i=1;
		foreach($comments as $eachComment){ if($i<=$number) 
		{
			$length = 40; // adjust to needed length
			$thiscomment = $eachComment->comment_content;
			if ( strlen($thiscomment) > $length ) 
			{
				$thiscomment = substr($thiscomment,0,$length);
				$thiscomment = $thiscomment .' ...';
			}
			$lengths = 25; // adjust to needed length
			$thiscomments = get_the_title($eachComment->comment_post_ID);
			if ( strlen($thiscomments) > $lengths ) 
			{
				$thiscomments = substr($thiscomments,0,$lengths);
				$thiscomments = $thiscomments .' ...';
			}
			if($eachComment->user_id==1) 
			{ 
				$user_info = get_userdata(1); $author_url = $user_info->user_url;
			} 
			else 
			{ 	
				$author_url = $eachComment->comment_author_url; 
			}
			echo '<li><span><a href="'.get_permalink($eachComment->comment_post_ID).'#comment-'.$eachComment->comment_ID.'">'.$thiscomment.'</a></span>';
			_e(' By ','framework'); 
			echo '<a href="'.$author_url.'">'.$eachComment->comment_author.'</a>'; 
			_e(' on ','framework'); 
			echo '<a href="'.get_permalink($eachComment->comment_post_ID).'">'.$thiscomments.'</a></li>'; $i++;
			} 
		} 
		echo '</ul>';
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
    	<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e(' Number of comments to show:','framework'); ?></label> <input class="widefat" 
        id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" style="WIDTH: 52px; HEIGHT: 25px;"  
        size=5 value="<?php echo $number; ?>" /></p>
	<?php 
	} 
} 
?>