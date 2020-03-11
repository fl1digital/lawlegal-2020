<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_color' ) ) {

    /**
     * Main IMIC_Framework_color class
     *
     * @since       1.0.0
     */
	class IMIC_Framework_color extends IMIC_Framework {
	
		/**
		 * Field Constructor.
		 *
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
	 	 * @since 		1.0.0
	 	 * @access		public
	 	 * @return		void
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
	 	 * @since 		1.0.0
	 	 * @access		public
	 	 * @return		void
		 */
		public function render() {

			echo '<input data-id="'.$this->field['id'].'" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . ']" id="' . $this->field['id'] . '-color" class="imic-color imic-color-init ' . $this->field['class'] . '"  type="text" value="' . $this->value . '"  data-default-color="' . $this->field['default'] . '" />';

			if ( !isset( $this->field['transparent'] ) || $this->field['transparent'] !== false ) {
				$tChecked = "";
				if ( $this->value == "transparent" ) {
					$tChecked = ' checked="checked"';
				}
				echo '<label for="' . $this->field['id'] . '-transparency" class="color-transparency-check"><input type="checkbox" class="checkbox color-transparency ' . $this->field['class'] . '" id="' . $this->field['id'] . '-transparency" data-id="'.$this->field['id'] . '-color" value="1"'.$tChecked.'> '.__('Transparent', 'imic-framework').'</label>';				
			}

		}
	
		/**
		 * Enqueue Function.
		 *
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since		1.0.0
		 * @access		public
		 * @return		void
		 */
		public function enqueue() {

			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script(
				'imic-field-color-js', 
				IMIC_Framework::$_url . 'inc/fields/color/field_color.min.js', 
				array( 'jquery', 'wp-color-picker' ),
				time(),
				true
			);

			wp_enqueue_style(
				'imic-field-color-css', 
				IMIC_Framework::$_url . 'inc/fields/color/field_color.css', 
				time(),
				true
			);
		
		}
	
	}
}