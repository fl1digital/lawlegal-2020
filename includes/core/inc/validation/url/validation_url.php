<?php
class IMIC_Validation_url extends IMIC_Framework {	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	*/
	function __construct($field, $value, $current) {
		
		parent::__construct();
		$this->field = $field;
		$this->field['msg'] = (isset($this->field['msg']))?$this->field['msg']:__('You must provide a valid URL for this option.', 'imic');
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
		
		if (filter_var($this->value, FILTER_VALIDATE_URL) == false) {
			$this->value = (isset($this->current))?$this->current:'';
			$this->error = $this->field;
		}else{
			$this->value = esc_url_raw($this->value);
		}
				
	}//function
	
}//class