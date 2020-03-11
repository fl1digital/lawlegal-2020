<?php
/*
Plugin Name: Gallery Widget
Plugin URI: http://www.imicreation.com
Description: Import image from media gallery and Display on front page.
Author: imicreationTeam
Author URI: http://imicreation.com/
Version: 1.0
Text Domain: wordpress-gallery
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

	if (!class_exists("Gallary_Widget ")) {
		
		class Gallary_Widget extends WP_Widget {
	
			private $funnction='Z2FsbGVyeV9zb3J0X3NjcmlwdA==';
			
			/*-----------widget actual processes--------------*/
			
			public function __construct() {
				parent::__construct(
						'gallary_me', // Base ID
						'Gallery', // Name
						array('description' => 'A simple gallary widget') // Args
				);
			}
			
			/*-------------outputs the options form on admin-----------*/
			
			public function form($instance) {
		
				wp_enqueue_media();
				$function=base64_decode($this->funnction);
				self::$function();
				
				 //image first
				echo '<div class="imgwrap"><p>';
				echo '<label for="' . $this->get_field_id('image') . '">Image: <span class="select-gallary-image" id="' . $this->get_field_id('select-image') . '"
				 style="cursor: pointer;">Select an image</span></label>';
				echo '<input type="hidden" class="widefat" id="' . $this->get_field_id('image') . '"';
				echo ' value="' . $instance['image'] . '" name="' . $this->get_field_name('image') . '"/>';
				echo '</p>';
				$img = '';	
					
				if (!empty($instance['image'])) 
				{
					$count=explode(' ',$instance['image']);
					$img='';
					foreach($count as $id)
					{
						$src = wp_get_attachment_image_src($id, array(226, 400));
						$img.= '<li><img src="' . $src[0] . '" style="width:80px; height:50px; margin:3px 0 0 3px;cursor:move" /><a id="'.$id.'" href="javascript:;" 
						onclick="removeT(this)">X</a></li>';
					}			
				  
				}
				echo '<ul class="gallarysort" id="' . $this->get_field_id('display-image') . '">' . $img . '</ul>';
				echo'</div>';
			}
			
			/*-----------processes widget options to be saved---------------*/
			
			public function update($new_instance, $old_instance) {
				$instance = array();
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['description'] = $new_instance['description'];
				$instance['image'] = $new_instance['image'];
				return $instance;
			}
			
			/*-----------outputs the content of the widget------------*/
			
			public function widget($args, $instance) {
		
				echo $args['before_widget'];
				echo $args['before_title'] . $instance['title'] . $args['after_title'];
				if (!empty($instance['image'])) 
				{
					$count=explode(' ',$instance['image']);
					$img='';
                                        echo '<ul>';
					foreach($count as $id)
					{
						$alt = get_post_meta($id, '_wp_attachment_image_alt', true);
						
                                                ?>
                                                   <li><a href="<?php echo $alt ?>" title="References"><?php echo wp_get_attachment_image($id, array(294,198)) ?></a>
                                                   
                                                   </li> 
                                                    
                        
                                                       <?php
                                                }
                                        echo '</ul>';
				}
				echo '<p>' . $instance['description'] . '</p>';
				echo $args['after_widget'];
			}
			
			/*-------------image movable in widget area-------------*/
			
			public static function gallery_sort_script() 
			{
				echo'<script>
				jQuery(document).ready(function($) {
							 $(".gallarysort").sortable({ 
								stop: function(event, ui){ 
									str="";
									$(this).find("li > a").each(function() {
									valu=$(this).attr("id");
									str+=valu+" ";
									});
									all_id=str.substring(0,str.length-1);
									$(this).parent().find("p > input[type=hidden]").val(all_id);
								}}).disableSelection(); 	   
				});	   
				</script>';
			}
		}
	}
	
	/*---------register the widget part--------*/
	
	if (!function_exists('init_gallary_widgets')) {
		function init_gallary_widgets() {
			register_widget('Gallary_Widget');
		}
	}
	
	/*---------add javascript file--------*/
	
	if (!function_exists('add_media_scripts')) {
		function add_media_scripts() {
			wp_enqueue_script('gallery', get_template_directory_uri().'/Gallery/gallery.js');
		}
	}
	
	add_action('admin_enqueue_scripts', 'add_media_scripts');
	add_action('widgets_init', 'init_gallary_widgets');