<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_image_select' ) ) {

    /**
     * Main IMIC_Framework_image_select class
     *
     * @since       1.0.0
     */
    class IMIC_Framework_image_select extends IMIC_Framework {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function __construct( $field = array(), $value = '', $parent = '' ) {
        
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
                
            if( !empty( $this->field['options'] ) ) {

                echo '<ul class="imic-image-select">';
            
                foreach( $this->field['options'] as $k => $v ) {

                    if( !is_array( $v ) )
                        $v = array( 'img' => $v );

                    if( !isset( $v['title'] ) )
                        $v['title'] = '';

                    if( !isset( $v['alt'] ) )
                        $v['alt'] = $v['title'];

                    $style = '';

                    if( !empty( $this->field['width'] ) ) {
                        $style .= 'width: ' . $this->field['width'];
                    
                        if( is_numeric( $this->field['width'] ) )
                            $style .= 'px';
                    
                        $style .= ';';
                    }

                    if( !empty( $this->field['height'] ) ) {
                        $style .= 'height: ' . $this->field['height'];

                        if( is_numeric( $this->field['height'] ) )
                            $style .= 'px';

                        $style .= ';';
                    }
                    $style .= " max-width: 100%; ";

                    $theValue = $k;
                    if( !empty( $this->field['tiles'] ) && $this->field['tiles'] == true ) {
                        $theValue = $v['img'];
                    }

                    $selected = ( checked( $this->value, $theValue, false ) != '' ) ? ' imic-image-select-selected' : '';

                    $presets = '';
                    $this->field['class'] .= ' noUpdate ';
                    if( !empty( $this->field['presets'] ) && $this->field['presets'] && !empty( $v['presets'] ) ) {

                        if( !is_array( $v['presets'] ) )
                            $v['presets'] = json_decode( $v['presets'], true );

                        $v['presets']['imic-backup'] = 1;

                        $presets = ' data-presets="' . htmlspecialchars( json_encode( $v['presets'] ), ENT_QUOTES, 'UTF-8' ) . '"';
                        $selected = '';
                        $this->field['class'] .= 'imic-presets';
                    }               

                    echo '<li class="imic-image-select">';
                    echo '<label class="' . $selected . ' imic-image-select-' . $this->field['id'] . '" for="' . $this->field['id'] . '_' . (array_search( $k, array_keys( $this->field['options'] ) ) + 1) . '">';

                    echo '<input type="radio" class="' . $this->field['class'] . '" id="' . $this->field['id'] . '_' . (array_search( $k, array_keys( $this->field['options'] ) ) + 1) . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . ']" value="' . $theValue . '" ' . checked( $this->value, $theValue, false ) . $presets . '/>';
                    
                    if( !empty( $this->field['tiles'] ) && $this->field['tiles'] == true ) {
                        echo '<span class="tiles" style="background-image: url(' . $v['img'] . ');" rel="'.$v['img'].'"">&nbsp;</span>';
                    } else {
                        echo '<img src="' . $v['img'] . '" alt="' . $v['alt'] . '" style="' . $style . '"' . $presets . ' />';
                    }
                
                    if ( $v['title'] != '' )
                        echo '<br /><span>' . $v['title'] . '</span>';  

                    echo '</label>';
                    echo '</li>';
                }
                
                echo '</ul>';       

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
        
            wp_enqueue_script(
                'imic-field-image-select-js', 
                IMIC_Framework::$_url . 'inc/fields/image_select/field_image_select.min.js', 
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_script('jquery-tipsy');

            wp_enqueue_style(
                'imic-field-image-select-css', 
                IMIC_Framework::$_url . 'inc/fields/image_select/field_image_select.css',
                time(),
                true
            );
        
        }
    }
}