<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'IMIC_Framework_edd_license' ) ) {

    /**
     * Main IMIC_Framework_color class
     *
     * @since       1.0.0
     */
	class IMIC_Framework_edd_license extends IMIC_Framework {
	
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

			// Create defaults array
			$defaults = array(
				'mode' => '',
				'path' => '',
				'remote_api_url' => '',
				'version' => '',
				'item_name' => '',
				'author' => '',
				'mode' => '',
			);

			$this->field = wp_parse_args( $this->field, $defaults );    

			$defaults = array(
				'license' 	=> '',
				'status' 	=> '',
			);

			$this->value = wp_parse_args( $this->value, $defaults );			

			$this->parent = $parent;		
		
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

			if ( !empty( $this->value['license'] ) ) {
				$transient = get_transient('imic_edd_license_'.$this->field['id'] . '_valid');
				if ( empty( $transient ) ) {
			        $data = array(
			          'edd_action'  => 'check_license',
			          'license'     => $this->value['license'],
			          'field_id'     => $this->field['id'],
			          'opt_name'     => $this->parent->args['opt_name'],
			          'item_name'   => urlencode( $this->field['item_name'] ),
			          'version'   => urlencode( $this->field['version'] ),
			          'author'   => urlencode( $this->field['author'] ),
			          'remote_api_url' => $this->field['remote_api_url']
			        );

			        $edd = IMIC_Framework_extension_edd::$theInstance;
			        $license_data = json_decode( $edd->license_call($data), true );
			        $this->value['status'] = $license_data['status'];
				} else {
					if (empty($this->value['status'])) {
						$this->value['status'] = $transient;	
					}
				}
			} else {
				$this->value['status'] = __('Not Activated', 'imic-framework');
			}
			$this->value['status'] = ucfirst( $this->value['status'] );

			if ( $this->value['status'] == __('Deactivated', 'imic-framework') ) {
				$noticeClasses = 'imic-warning imic-info-field';
			} else if ( $this->value['status'] == __('Valid', 'imic-framework') ) {
				$noticeClasses = 'imic-success imic-info-field';
			} else {
				$noticeClasses = 'imic-critical imic-info-field';
			}

			echo '<div id="' . $this->field['id'] . '-notice" class="'.$noticeClasses.'">';
			echo '<b>' . __('License Status', 'imic-framework') . ': <span id="' . $this->field['id'] . '-status_notice">'.ucfirst($this->value['status']).'</span></b></div>';

			echo '<input type="hidden" class="imic-edd " type="text" id="' . $this->field['id'] . '-field_id" value="' . $this->field['id'] . '" " />'; 
			echo '<input type="hidden" class="imic-edd " type="text" id="' . $this->field['id'] . '-remote_api_url" value="' . $this->field['remote_api_url'] . '" " />'; 
			echo '<input type="hidden" class="imic-edd " type="text" id="' . $this->field['id'] . '-version" value="' . $this->field['version'] . '" " />'; 
			echo '<input type="hidden" class="imic-edd " type="text" id="' . $this->field['id'] . '-item_name" value="' . $this->field['item_name'] . '" " />'; 
			echo '<input type="hidden" class="imic-edd " type="text" id="' . $this->field['id'] . '-author" value="' . $this->field['author'] . '" " />'; 
			echo '<input name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][license]"  id="' . $this->field['id'] . '-license" class="imic-edd-input imic-edd ' . $this->field['class'] . '"  type="text" value="' . $this->value['license'] . '" " />'; 
			echo '<input type="hidden" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][status]" id="' . $this->field['id'] . '-status" class="imic-edd imic-edd-status ' . $this->field['class'] . '" type="text" value="' . $this->value['status'] . '" " />'; 
			echo '<a href="#" data-id="'.$this->field['id'].'" class="button button-primary imic-EDDAction hide" data-edd_action="check_license">'.__('Verify License', 'imic-framework').'</a>';
			$hide = "";
			if ($this->value['status'] == "Valid") {
				$hide = " hide";
			}
			echo '&nbsp; <a href="#" id="'.$this->field['id'].'-activate" data-id="'.$this->field['id'].'" class="button button-primary imic-EDDAction'.$hide.'" data-edd_action="activate_license">'.__('Activate License', 'imic-framework').'</a>';
			$hide = "";
			if ($this->value['status'] != "Valid") {
				$hide = " hide";
			}			
			echo '&nbsp; <a href="#" id="'.$this->field['id'].'-deactivate" data-id="'.$this->field['id'].'" class="button button-secondary imic-EDDAction'.$hide.'" data-edd_action="deactivate_license">'.__('Deactivate License', 'imic-framework').'</a>';
			if (isset($this->parent->args['edd'])) {
				foreach( $this->parent->args['edd'] as $k => $v ) {
					echo '<input type="hidden" data-id="'.$this->field['id'].'" id="' . $this->field['id'] . '-'.$k.'" class="imic-edd edd-'.$k.'"  type="text" value="' . $v . '" " />';
				}
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

            wp_enqueue_style(
                'imic-field-info-css',
                IMIC_Framework::$_url . 'inc/fields/info/field_info.css',
                time(),
                true
            );

			wp_enqueue_script(
				'imic-field-edd-js', 
				IMIC_Framework::$_url . 'extensions/edd/edd_license/field_edd_license.js', 
				array( 'jquery' ),
				time(),
				true
			);

			wp_enqueue_style(
				'imic-field-edd-css', 
				IMIC_Framework::$_url . 'extensions/edd/edd_license/field_edd_license.css', 
				time(),
				true
			);
		
		}
	}
}