<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Don't duplicate me!
if (!class_exists('IMIC_Framework_slides')) {

    /**
     * Main IMIC_Framework_slides class
     *
     * @since       1.0.0
     */
    class IMIC_Framework_slides extends IMIC_Framework
    {

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function __construct($field = array(), $value = '', $parent)
        {

            parent::__construct($parent->sections, $parent->args);

            $this->field = $field;
            $this->value = $value;

        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            echo '<div class="imic-slides-accordion">';

            $x = 0;

            if (isset($this->value) && is_array($this->value)) {

                $slides = $this->value;

                foreach ($slides as $slide) {
                    
                    if ( empty( $slide ) ) {
                        continue;
                    }

                    $defaults = array(
                        'title' => '',
                        'description' => '',
                        'sort' => '',
                        'url' => '',
                        'thumb' => '',
                        'attachment_id' => '',
                        'height' => '',
                        'width' => ''
                    );
                    $slide = wp_parse_args( $slide, $defaults );

                    if (empty($slide['url']) && !empty($slide['attachment_id'])) {
                        $img = wp_get_attachment_image_src($slide['attachment_id'], 'full');
                        $slide['url'] = $img[0];
                        $slide['width'] = $img[1];
                        $slide['height'] = $img[2];
                    }

                    echo '<div class="imic-slides-accordion-group"><fieldset class="imic-field"><h3><span class="imic-slides-header">' . $slide['title'] . '</span></h3><div>';

                    $hide = '';
                    if ( empty( $slide['url'] ) ) {
                        $hide = ' hide';
                    }

                    echo '<div class="screenshot' . $hide . '">';
                    echo '<a class="of-uploaded-image" href="' . $slide['url'] . '">';
                    echo '<img class="imic-slides-image" id="image_image_id_' . $x . '" src="' . $slide['thumb'] . '" alt="" />';
                    echo '</a>';
                    echo '</div>';

                    echo '<div class="imic_slides_add_remove">';

                    echo '<span class="button media_upload_button" id="add_' . $x . '">' . __('Upload', 'imic-framework') . '</span>';

                    $hide = '';
                    if (empty($slide['url']) || $slide['url'] == '')
                        $hide = ' hide';

                    echo '<span class="button remove-image' . $hide . '" id="reset_' . $x . '" rel="' . $slide['attachment_id'] . '">' . __('Remove', 'imic-framework') . '</span>';

                    echo '</div>' . "\n";

                    echo '<ul id="' . $this->field['id'] . '-ul" class="imic-multi-text">';
                    echo '<li><input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title]" value="' . esc_attr($slide['title']) . '" placeholder="'.__('Title', 'imic-framework').'" class="full-text slide-title" /></li>';
                    echo '<li><textarea name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][description]" id="' . $this->field['id'] . '-description_' . $x . '" placeholder="'.__('Description', 'imic-framework').'" class="large-text" rows="6">' . esc_attr($slide['description']) . '</textarea></li>';
                    echo '<li><input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][url]" value="' . esc_attr($slide['url']) . '" class="full-text" placeholder="'.__('URL', 'imic-framework').'" /></li>';
                    echo '<li><input type="hidden" class="slide-sort" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][sort]" id="' . $this->field['id'] . '-sort_' . $x . '" value="' . $slide['sort'] . '" />';
                    echo '<li><input type="hidden" class="upload-id" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][attachment_id]" id="' . $this->field['id'] . '-image_id_' . $x . '" value="' . $slide['attachment_id'] . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][thumb]" id="' . $this->field['id'] . '-thumb_url_' . $x . '" value="' . $slide['thumb'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][image]" id="' . $this->field['id'] . '-image_url_' . $x . '" value="' . $slide['image'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-height" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][height]" id="' . $this->field['id'] . '-image_height_' . $x . '" value="' . $slide['height'] . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][width]" id="' . $this->field['id'] . '-image_width_' . $x . '" value="' . $slide['width'] . '" /></li>';
                    echo '<li><a href="javascript:void(0);" class="button deletion imic-slides-remove">' . __('Delete Slide', 'imic-framework') . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x++;
                
                }
            }

            if ($x == 0) {
                echo '<div class="imic-slides-accordion-group"><fieldset class="imic-field"><h3><span class="imic-slides-header">New Slide</span></h3><div>';

                $hide = ' hide';

                echo '<div class="screenshot' . $hide . '">';
                echo '<a class="of-uploaded-image" href="">';
                echo '<img class="imic-slides-image" id="image_image_id_' . $x . '" src="" alt="" />';
                echo '</a>';
                echo '</div>';

                //Upload controls DIV
                echo '<div class="upload_button_div">';

                //If the user has WP3.5+ show upload/remove button
                echo '<span class="button media_upload_button" id="add_' . $x . '">' . __('Upload', 'imic-framework') . '</span>';

                echo '<span class="button remove-image' . $hide . '" id="reset_' . $x . '" rel="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][attachment_id]">' . __('Remove', 'imic-framework') . '</span>';

                echo '</div>' . "\n";

                echo '<ul id="' . $this->field['id'] . '-ul" class="imic-multi-text">';
                echo '<li><input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title]" value="" placeholder="'.__('Title', 'imic-framework').'" class="full-text slide-title" /></li>';
                echo '<li><textarea name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][description]" id="' . $this->field['id'] . '-description_' . $x . '" placeholder="'.__('Description', 'imic-framework').'" class="large-text" rows="6"></textarea></li>';
                echo '<li><input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][url]" value="" class="full-text" placeholder="'.__('URL', 'imic-framework').'" /></li>';
                echo '<li><input type="hidden" class="slide-sort" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][sort]" id="' . $this->field['id'] . '-sort_' . $x . '" value="' . $x . '" />';
                echo '<li><input type="hidden" class="upload-id" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][attachment_id]" id="' . $this->field['id'] . '-image_id_' . $x . '" value="" />';
                echo '<input type="hidden" class="upload" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][url]" id="' . $this->field['id'] . '-image_url_' . $x . '" value="" readonly="readonly" />';
                echo '<input type="hidden" class="upload-height" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][height]" id="' . $this->field['id'] . '-image_height_' . $x . '" value="" />';
                echo '<input type="hidden" class="upload-width" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][width]" id="' . $this->field['id'] . '-image_width_' . $x . '" value="" /></li>';
                echo '<li><a href="javascript:void(0);" class="button deletion imic-slides-remove">' . __('Delete Slide', 'imic-framework') . '</a></li>';
                echo '</ul></div></fieldset></div>';
            }
            echo '</div><a href="javascript:void(0);" class="button imic-slides-add button-primary" rel-id="' . $this->field['id'] . '-ul" rel-name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][title][]">' . __('Add Slide', 'imic-framework') . '</a><br/>';
            
        }

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */

        public function enqueue() {


            wp_enqueue_script(
                'imic-field-media-js',
                IMIC_Framework::$_url . 'inc/fields/media/field_media.js',
                array( 'jquery', 'wp-color-picker' ),
                time(),
                true
            );

            wp_enqueue_style(
                'imic-field-media-css',
                IMIC_Framework::$_url . 'inc/fields/media/field_media.css',
                time(),
                true
            );            

            wp_enqueue_script(
                'imic-field-slides-js',
                IMIC_Framework::$_url . 'inc/fields/slides/field_slides.min.js',
                array('jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'wp-color-picker'),
                time(),
                true
            );

            if (function_exists('wp_enqueue_media')) {
                wp_enqueue_media();
            }
            else {
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_enqueue_style('thickbox');
            }

            wp_enqueue_style(
                'imic-field-slides-css',
                IMIC_Framework::$_url . 'inc/fields/slides/field_slides.css',
                time(),
                true
            );


        }

    }
}
