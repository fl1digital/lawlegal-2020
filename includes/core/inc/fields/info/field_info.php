<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_info' ) ) {

    /**
     * Main IMIC_Framework_info class
     *
     * @since       1.0.0
     */
    class IMIC_Framework_info extends IMIC_Framework {
    
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

        	if ( !isset( $this->field['style'] ) ) {
        		$this->field['style'] = "";
        	}

            if( empty( $this->field['desc'] ) && !empty( $this->field['default'] ) ) {
            	$this->field['desc'] = $this->field['default'];
            	unset($this->field['default']);
            }       

            if( empty( $this->field['desc'] ) && !empty( $this->field['subtitle'] ) ) {
            	$this->field['desc'] = $this->field['subtitle'];
            	unset($this->field['subtitle']);
            }         

            if ( empty( $this->field['desc'] ) ) {
            	$this->field['desc'] = "";
            }

            if( empty( $this->field['raw_html'] ) ) {
                $this->field['class'] .= ' imic-info-field';

                if( empty( $this->field['style'] ) ) {
                    $this->field['style'] = 'normal';
                }

                $this->field['style'] = 'imic-' . $this->field['style'].' ';
            }

            echo '</td></tr></table><div id="' . $this->field['id'] . '" class="' . $this->field['style'] . $this->field['class'] . '">';

            	if ( !empty($this->field['raw_html']) && $this->field['raw_html'] ) {
            		echo $this->field['desc'];
            	} else {
		            if( !empty( $this->field['title'] ) ) {
		                $this->field['title'] = '<b>' . $this->field['title'] . '</b><br/>';
		            } else {
		                $this->field['title'] = '';
		            }

		            if( isset( $this->field['icon'] ) && !empty( $this->field['icon'] ) && $this->field['icon'] !== true ) {
		                echo '<p class="imic-info-icon"><i class="' . $this->field['icon'] . ' icon-large"></i></p>';
		            }

	            	echo '<p class="imic-info-desc">' . $this->field['title'] . $this->field['desc'] . '</p>';

            	}

            echo '</div><table class="form-table no-border" style="margin-top: 0;"><tbody><tr><th></th><td>';
        
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
                'imic-field-info-css',
                IMIC_Framework::$_url . 'inc/fields/info/field_info.css',
                time(),
                true
            );

        }

    }
}
