<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_link_color' ) ) {

    /**
     * Main IMIC_Framework_link_color class
     *
     * @since       1.0.0
     */
    class IMIC_Framework_link_color extends IMIC_Framework {
    
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

            $defaults = array(
                'regular' => true,
                'hover' => true,
                'active' => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );

            $defaults = array(
                'regular' => '',
                'hover' => '',
                'active' => ''
            );

            $this->value = wp_parse_args( $this->value, $defaults );
            $this->field['default'] = wp_parse_args( $this->field['default'], $defaults );

            if ($this->field['regular'] == true):

            echo '<strong>' . __( 'Regular', 'imic-framework' ) . '</strong>&nbsp;<input id="' . $this->field['id'] . '-regular" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][regular]" value="'.$this->value['regular'].'" class="imic-color imic-color-init ' . $this->field['class'] . '"  type="text" data-default-color="' . $this->field['default']['regular'] . '" />&nbsp;&nbsp;&nbsp;&nbsp;';

            endif;

            if ($this->field['hover'] == true):

            echo '<strong>' . __( 'Hover', 'imic-framework' ) . '</strong>&nbsp;<input id="' . $this->field['id'] . '-hover" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][hover]" value="' . $this->value['hover'] . '" class="imic-color imic-color-init ' . $this->field['class'] . '"  type="text" data-default-color="' . $this->field['default']['hover'] . '" />&nbsp;&nbsp;&nbsp;&nbsp;';

            endif;

            if ($this->field['active'] == true):

            echo '<strong>' . __( 'Active', 'imic-framework' ) . '</strong>&nbsp;<input id="' . $this->field['id'] . '-active" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][active]" value="' . $this->value['active'] . '" class="imic-color imic-color-init ' . $this->field['class'] . '"  type="text" data-default-color="' . $this->field['default']['active'] . '" />';

            endif;
        
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
                'imic-field-color-js', 
                IMIC_Framework::$_url . 'inc/fields/color/field_color.min.js', 
                array( 'jquery', 'wp-color-picker' ),
                time(),
                true
            );

            wp_enqueue_style(
                'imic-field-color-js', 
                IMIC_Framework::$_url . 'inc/fields/color/field_color.css', 
                time(),
                true
            ); 
               
        }
    }
}
?>
