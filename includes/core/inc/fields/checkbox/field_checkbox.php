<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_checkbox' ) ) {

    /**
     * Main IMIC_Framework_checkbox class
     * @since       1.0.0
     */
    class IMIC_Framework_checkbox extends IMIC_Framework {   
    
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

	        if( !empty( $this->field['data'] ) && empty( $this->field['options'] ) ) {
				if (empty($this->field['args'])) {
					$this->field['args'] = array();
				}        	
	        	$this->field['options'] = $parent->get_wordpress_data($this->field['data'], $this->field['args']);
	        }
            $this->field['data_class'] = ( isset($this->field['multi_layout']) ) ? 'data-'.$this->field['multi_layout'] : 'data-full';
        
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

	            if( !empty( $this->field['options'] ) && ( is_array( $this->field['options'] ) || is_array( $this->field['default'] ) ) ) {
	                echo '<ul class="'.$this->field['data_class'].'">';
	            	if ( !isset( $this->value ) ) {
	            		$this->value = array();
	            	}
	            	if (!is_array($this->value)) {
	            		$this->value = array();
	            	}

	                foreach( $this->field['options'] as $k => $v ) {
	                	
	                    if (empty($this->value[$k])) {
	                    	$this->value[$k] = "";
	                    }
	                    	
	                    echo '<li>';
	                    echo '<label for="' . strtr($this->args['opt_name'] . '[' . $this->field['id'] . '][' . $k . ']', array('[' => '_', ']' => '')) . '_' . array_search( $k, array_keys( $this->field['options'] ) ) . '">';
	                    echo '<input type="checkbox" class="checkbox ' . $this->field['class'] . '" id="' . strtr($this->args['opt_name'] . '[' . $this->field['id'] . '][' . $k . ']', array('[' => '_', ']' => '')) . '_' . array_search( $k, array_keys( $this->field['options'] ) ) . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $k . ']" value="1" ' . checked( $this->value[$k], '1', false ) . '/>';
	                    echo ' ' . $v . '</label>';
	                    echo '</li>';
	                
	                }

	                echo '</ul>';   

	            } else {

	                echo ( ! empty( $this->field['desc'] ) ) ? ' <label for="' . strtr($this->args['opt_name'] . '[' . $this->field['id'] . ']', array('[' => '_', ']' => '')) . '">' : '';
	                
	                // Got the "Checked" status as "0" or "1" then insert it as the "value" option
	        	$ch_value = checked( $this->value, '1', false )== "" ? "0" : "1";
	                echo '<input type="checkbox" id="' . strtr($this->args['opt_name'] . '[' . $this->field['id'] . ']', array('[' => '_', ']' => '')) . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . ']" value="' . $ch_value . '" class="checkbox ' . $this->field['class'] . '" ' . checked( $this->value, '1', false ) . '/>';
	        
	            }

        }
    }
}
