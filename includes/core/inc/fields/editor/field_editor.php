<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_editor' ) ) {

    /**
     * Main IMIC_Framework_editor class
     *
     * @since       1.0.0
     */
    class IMIC_Framework_editor extends IMIC_Framework {
    
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
    	
            $settings = array(
                'textarea_name' => $this->args['opt_name'] . '[' . $this->field['id'] . ']', 
                'editor_class'  => $this->field['class'],
                'textarea_rows' => 8,
                'teeny' => true,
            );

            wp_editor( $this->value, $this->field['id'], $settings );

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

            wp_enqueue_style(
                'imic-field-editor-css', 
                IMIC_Framework::$_url . 'inc/fields/editor/field_editor.css',
                time(),
                true
            );
        
        }

    }
}