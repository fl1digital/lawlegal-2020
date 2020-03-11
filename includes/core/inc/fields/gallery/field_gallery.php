<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// Don't duplicate me!
if (!class_exists('IMIC_Framework_gallery')) {

    /**
     * Main IMIC_Framework_gallery class
     *
     * @since       3.0.0
     */
    class IMIC_Framework_gallery extends IMIC_Framework {

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function __construct($field = array(), $value = '', $parent) {

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

            
            echo '<div class="screenshot">';
            if (!empty($this->value)) :
                $ids = explode(',', $this->value);
                foreach ($ids as $attachment_id) {
                    $img = wp_get_attachment_image_src($attachment_id, 'thumbnail');
                    echo '<a class="of-uploaded-image" href="' . $img[0] . '">';
                    echo '<img class="imic-option-image" id="image_' . $this->field['id'] .'_'.$attachment_id. '" src="' . $img[0] . '" alt="" />';
                    echo '</a>';
                }
            endif;
            echo '</div>';
            echo '<a href="#" onclick="return false;" id="edit-gallery" class="gallery-attachments button button-primary">' . __('Add/Edit Gallery', 'imic-framework') . '</a> ';
            echo '<a href="#" onclick="return false;" id="clear-gallery" class="gallery-attachments button">' . __('Clear Gallery', 'imic-framework') . '</a>';            echo '<input type="hidden" class="gallery_values ' . $this->field['class'] . '" value="' . esc_attr($this->value) . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . ']" />';


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

            if (function_exists('wp_enqueue_media')) {
                wp_enqueue_media();
            } else {
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_enqueue_style('thickbox');
            }

            wp_enqueue_script(
                    'imic-field-gallery-js', IMIC_Framework::$_url . 'inc/fields/gallery/field_gallery.js', array('jquery', 'wp-color-picker'), time(), true
            );

        }

    }

}