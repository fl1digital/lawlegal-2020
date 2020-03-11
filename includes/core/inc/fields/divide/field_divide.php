<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_divide' ) ) {

    /**
     * Main IMIC_Framework_divide class
     *
     * @since       1.0.0
     */
	class IMIC_Framework_divide extends IMIC_Framework {
	
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

			echo '</td></tr></table>';
			echo '<div data-id="'.$this->field['id'].'" id="'.$this->field['id'].'-divide" class="hr ' . $this->field['class'] . '"/><div class="inner"><span>&nbsp;</span></div></div>';
			echo '<table class="form-table no-border"><tbody><tr><th></th><td>';

		}
	}	
}