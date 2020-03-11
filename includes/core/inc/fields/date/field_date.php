<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_date' ) ) {

    /**
     * Main IMIC_Framework_date class
     *
     * @since       1.0.0
     */
	class IMIC_Framework_date extends IMIC_Framework {
	
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
    			$placeholder = (isset($this->field['placeholder'])) ? ' placeholder="' . esc_attr($this->field['placeholder']) . '" ' : '';
                                                
    			echo '<input data-id="'.$this->field['id'].'" type="text" id="'. $this->field['id'] .'-date" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . ']"' . $placeholder . 'value="' . $this->value . '" class="imic-datepicker ' . $this->field['class'] . '" />';
		}
	
		/**
	 	 * Enqueue Function.
		 *
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since 		1.0.0
		 * @access		public
		 * @return		void
		 */
		public function enqueue() {
			wp_enqueue_script(
				'imic-field-date-js', 
				IMIC_Framework::$_url . 'inc/fields/date/field_date.min.js',
				array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ),
				time(),
				true
			);
		}
	}
}
