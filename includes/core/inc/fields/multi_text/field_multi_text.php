<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_multi_text' ) ) {

    /**
     * Main IMIC_Framework_multi_text class
     *
     * @since       1.0.0
     */
    class IMIC_Framework_multi_text extends IMIC_Framework {
    
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
            
            $this->add_text = ( isset($this->field['add_text']) ) ? $this->field['add_text'] : __( 'Add More', 'imic-framework');
            
            $this->show_empty = ( isset($this->field['show_empty']) ) ? $this->field['show_empty'] : true;
        
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

            echo '<ul id="' . $this->field['id'] . '-ul" class="imic-multi-text">';
        
                if( isset( $this->value ) && is_array( $this->value ) ) {
                    foreach( $this->value as $k => $value ) {
                        if( $value != '' )
                            echo '<li><input type="text" id="' . $this->field['id'] . '-' . $k . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][]" value="' . esc_attr( $value ) . '" class="regular-text ' . $this->field['class'] . '" /> <a href="javascript:void(0);" class="deletion imic-multi-text-remove">' . __( 'Remove', 'imic-framework' ) . '</a></li>';
                    }
                } elseif($this->show_empty == true ) {
                    echo '<li><input type="text" id="' . $this->field['id'] . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][]" value="" class="regular-text ' . $this->field['class'] . '" /> <a href="javascript:void(0);" class="deletion imic-multi-text-remove">' . __( 'Remove', 'imic-framework' ) . '</a></li>';
                }
            
                echo '<li style="display:none;"><input type="text" id="' . $this->field['id'] . '" name="" value="" class="regular-text" /> <a href="javascript:void(0);" class="deletion imic-multi-text-remove">' . __( 'Remove', 'imic-framework') . '</a></li>';

            echo '</ul>';
        
            echo '<a href="javascript:void(0);" class="button button-primary imic-multi-text-add" rel-id="' . $this->field['id'] . '-ul" rel-name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][]">' . $this->add_text . '</a><br/>';

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
                'imic-field-multi-text-js', 
                IMIC_Framework::$_url . 'inc/fields/multi_text/field_multi_text.min.js', 
                array( 'jquery' ),
                time(),
                true
            );

			wp_enqueue_style(
				'imic-field-multi-text-css', 
				IMIC_Framework::$_url.'inc/fields/multi_text/field_multi_text.css', 
				time(),
				true
			);            
        
        }
    }   
}