<?php
class IMIC_Framework_switch extends IMIC_Framework{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args);
		$this->field = $field;
		$this->value = $value;
		//$this->render();
		
	}//function
	


	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	*/
	function render(){
		
		$cb_enabled = $cb_disabled = '';//no errors, please

		//Get selected
		if ( (int) $this->value == 1 ){
			$cb_enabled = ' selected';
		}else {
			$cb_disabled = ' selected';
		}
		
		//Label ON
		if(!isset($this->field['on'])){
			$on = "On";
		}else{
			$on = $this->field['on'];
		}
		
		//Label OFF
		if(!isset($this->field['off'])){
			$off = "Off";
		} else{
			$off = $this->field['off'];
		}

		echo '<div class="switch-options">';
			echo '<label class="cb-enable'. $cb_enabled .'" data-id="'.$this->field['id'].'"><span>'. $on .'</span></label>';
			echo '<label class="cb-disable'. $cb_disabled .'" data-id="'.$this->field['id'].'"><span>'. $off .'</span></label>';
			echo '<input type="hidden" class="checkbox checkbox-input'.$this->field['class'].'" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'.$this->value.'" />';
		echo '</div>';

	}//function
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	*/
	function enqueue(){
		
		wp_enqueue_script(
			'imic-field-switch-js', 
			IMIC_Framework::$_url.'inc/fields/switch/field_switch.min.js', 
			array('jquery'),
			time(),
			true
		);		

		wp_enqueue_style(
			'imic-field-switch-css', 
			IMIC_Framework::$_url.'inc/fields/switch/field_switch.css', 
			time(),
			true
		);		

	}//function

}//class