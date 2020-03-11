<?php
class IMIC_Validation_css extends IMIC_Framework {	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	*/
	function __construct($field, $value, $current) {
		
		parent::__construct();
		$this->field = $field;
		$this->value = $value;
		$this->current = $current;
		$this->validate();
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and validates them
	*/
	function validate() {
		
		// Strip all html
		$this->value = wp_filter_nohtml_kses($this->value);
				
	}//function
	
}//class
