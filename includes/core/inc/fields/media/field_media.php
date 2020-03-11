<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_media' ) ) {

    /**
     * Main IMIC_Framework_media class
     *
     * @since       1.0.0
     */
    class IMIC_Framework_media extends IMIC_Framework {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function __construct( $field = array(), $value ='', $parent ) {
        
            parent::__construct( $parent->sections, $parent->args );

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

            // No errors please
            $defaults = array(
                'id'        => '',
                'url'       => '',
                'width'     => '',
                'height'    => '',
                'thumbnail' => ''
            );

            $this->value = wp_parse_args( $this->value, $defaults );

            if ( !isset( $this->field['mode'] ) ) {
                $this->field['mode'] = "image";
            }

            if( empty( $this->value ) && !empty( $this->field['default'] ) ) { // If there are standard values and value is empty
                if( is_array( $this->field['default'] ) ) {
                    if( !empty( $this->field['default']['id'] ) ) {
                        $this->value['id'] = $this->field['default']['id'];
                    }

                    if( !empty( $this->field['default']['url'] ) ) {
                        $this->value['url'] = $this->field['default']['url'];
                    }           
                } else {
                    if( is_numeric( $this->field['default'] ) ) { // Check if it's an attachment ID
                        $this->value['id'] = $this->field['default'];
                    } else { // Must be a URL
                        $this->value['url'] = $this->field['default'];
                    }           
                }
            }


            if( empty( $this->value['url'] ) && !empty( $this->value['id'] ) ) {
                $img = wp_get_attachment_image_src( $this->value['id'], 'full' );
                $this->value['url'] = $img[0];
                $this->value['width'] = $img[1];
                $this->value['height'] = $img[2];
            }

            $hide = 'hide ';

            if( (isset( $this->field['preview'] ) && $this->field['preview'] === false) ) {
                $this->field['class'] .= " noPreview";
            }

            if( ( !empty( $this->field['url'] ) && $this->field['url'] === true ) || isset( $this->field['preview'] ) && $this->field['preview'] === false ) {
                $hide = '';
            }   

            echo '<input placeholder="'.__('None media selected', 'imic-framework').'" type="text" class="' . $hide . 'upload ' . $this->field['class'] . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][url]" id="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][url]" value="' . $this->value['url'] . '" readonly="readonly" />';
            echo '<input type="hidden" class="upload-id ' . $this->field['class'] . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][id]" id="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][id]" value="' . $this->value['id'] . '" />';
            echo '<input type="hidden" class="upload-height" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][height]" id="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][height]" value="' . $this->value['height'] . '" />';
            echo '<input type="hidden" class="upload-width" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][width]" id="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][width]" value="' . $this->value['width'] . '" />';
            echo '<input type="hidden" class="upload-thumbnail" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][thumbnail]" id="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][thumbnail]" value="' . $this->value['thumbnail'] . '" />';

            //Preview
            $hide = '';

            if( (isset( $this->field['preview'] ) && $this->field['preview'] === false) || empty( $this->value['url'] ) ) {
                $hide = 'hide ';
            }

            if ( empty( $this->value['thumbnail'] ) && !empty( $this->value['url'] ) ) { // Just in case
                if ( !empty( $this->value['id'] ) ) {
                    $image = wp_get_attachment_image_src( $this->value['id'], array(150, 150) );
                    $this->value['thumbnail'] = $image[0];
                } else {
                    $this->value['thumbnail'] = $this->value['url'];    
                }
            }

            echo '<div class="' . $hide . 'screenshot">';
            echo '<a class="of-uploaded-image" href="' . $this->value['url'] . '">';
            echo '<img class="imic-option-image" id="image_' . $this->field['id'] . '" src="' . $this->value['thumbnail'] . '" alt="" />';
            echo '</a>';
            echo '</div>';
        
            //Upload controls DIV
            echo '<div class="upload_button_div">';

            //If the user has WP3.5+ show upload/remove button
            echo '<span class="button media_upload_button" id="' . $this->field['id'] . '-media">' . __( 'Upload', 'imic-framework' ) . '</span>';
            
            $hide = '';
            if( empty( $this->value['url'] ) || $this->value['url'] == '' )
                $hide =' hide';

            echo '<span class="button remove-image' . $hide . '" id="reset_' . $this->field['id'] . '" rel="' . $this->field['id'] . '">' . __( 'Remove', 'imic-framework' ) . '</span>';

            echo '</div>';  

            if ( ( isset( $this->field['mode'] ) && !empty( $this->field['mode'] ) ) || $this->field['mode'] != false ) {
                // Use javascript globalization, better than any other method.
                global $wp_scripts;
                $data = $wp_scripts->get_data('imic-field-media-js', 'data');

                if(!empty($data)) { // Adding to the previous localize script object
                  if(!is_array($data)) {
                    $data = json_decode(str_replace('var imicMedia = ', '', substr($data, 0, -1)), true);
                  }
                  foreach($data as $key => $value) {
                    $localized_data[$key] = $value;
                  }
                  $wp_scripts->add_data('imic-field-media-js', 'data', '');
                }
                $localized_data[$this->field['id']] = $this->field['mode'];
                wp_localize_script('imic-field-media-js', 'imicMedia', $localized_data);                  
            }
                           
            
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

            if( function_exists( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            } else {
                wp_enqueue_script( 'media-upload' );
                wp_enqueue_script( 'thickbox' );
                wp_enqueue_style( 'thickbox' );
            }

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

        }
    }
}