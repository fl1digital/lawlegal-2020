<?php
class IMIC_Framework_dimensions extends IMIC_Framework {

    /**
     * Field Constructor.
     *
     * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
     */
    function __construct($field = array(), $value = '', $parent) {

        parent::__construct($parent->sections, $parent->args);
        $this->field = $field;
        $this->value = $value;
        //$this->render();
    }

//function

    /**
     * Field Render Function.
     *
     * Takes the vars and outputs the HTML for the field in the settings
     */
    function render() {

        if( !function_exists( 'array_in_array' ) ) {
            function array_in_array($needle, $haystack) {
                //Make sure $needle is an array for foreach
                if (!is_array($needle)) {
                    $needle = array($needle);
                }
                //For each value in $needle, return TRUE if in $haystack
                foreach ($needle as $pin)
                //echo 'needle' . $pin;
                    if (in_array($pin, $haystack)) {
                        return true;
                    }
                //Return FALSE if none of the values from $needle are found in $haystack
                return false;
            }
        }

        // No errors please
        $defaults = array(
            'width' => true,
            'height' => true,
            'units_extended' => false,
            'units' => 'px',
        );

        $this->field = wp_parse_args($this->field, $defaults);

        $defaults = array(
            'width' => '',
            'height' => '',
            'units' => 'px'
        );

        $this->value = wp_parse_args($this->value, $defaults);

        /*
         * Acceptable values checks.  If the passed variable doesn't pass muster, we unset them
         * and reset them with default values to avoid errors.
         */

        // If units field has a value but is not an acceptable value, unset the variable
        if (isset($this->field['units']) && !array_in_array($this->field['units'], array('', false, '%', 'in', 'cm', 'mm', 'em', 'ex', 'pt', 'pc', 'px'))) {
            unset($this->field['units']);
        }

        //if there is a default unit value  but is not an accepted value, unset the variable
        if (isset($this->value['units']) && !array_in_array($this->value['units'], array('', '%', 'in', 'cm', 'mm', 'em', 'ex', 'pt', 'pc', 'px'))) {
            unset($this->value['units']);
        }

        /*
         * Since units field could be an array, string value or bool (to hide the unit field)
         * we need to separate our functions to avoid those nasty PHP index notices!
         */

        // if field units has a value and IS an array, then evaluate as needed.
        if (isset($this->field['units']) && !is_array($this->field['units'])) {

            //if units fields has a value but units value does not then make units value the field value
            if (isset($this->field['units']) && !isset($this->value['units']) || $this->field['units'] == false) {
                $this->value['units'] = $this->field['units'];

            // If units field does NOT have a value and units value does NOT have a value, set both to blank (default?)
            } else if (!isset($this->field['units']) && !isset($this->value['units'])) {
                $this->field['units'] = 'px';
                $this->value['units'] = 'px';

            // If units field has NO value but units value does, then set unit field to value field
            } else if (!isset($this->field['units']) && isset($this->value['units'])) {
                $this->field['units'] = $this->value['units'];
                
            // if unit value is set and unit value doesn't equal unit field (coz who knows why)
            // then set unit value to unit field
            } elseif (isset($this->value['units']) && $this->value['units'] !== $this->field['units']) {
                $this->value['units'] = $this->field['units'];
            }

        // do stuff based on unit field NOT set as an array
        } elseif (isset($this->field['units']) && is_array($this->field['units'])) {
            // nothing to do here, but I'm leaving the construct just in case I have to debug this again.
        }

        echo '<fieldset id="' . $this->field['id'] . '" class="imic-dimensions-container" data-id="' . $this->field['id'] . '">';
        
        // This used to be unit field, but was giving the PHP index error when it was an array,
        // so I changed it.
        echo '<input type="hidden" class="field-units" value="' . $this->value['units'] . '">';
        
        /**
          Width
         * */
        if ($this->field['width'] === true):
            if (!empty($this->value['width']) && strpos($this->value['width'], $this->value['units']) === false) {
                $this->value['width'] = filter_var($this->value['width'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                if ($this->field['units'] !== false) {
                    $this->value['width'] .= $this->value['units'];
                }
            }
            echo '<div class="field-dimensions-input input-prepend">';
            echo '<span class="add-on"><i class="el-icon-resize-horizontal icon-large"></i></span>';
            echo '<input type="text" class="imic-dimensions-input imic-dimensions-width mini' . $this->field['class'] . '" placeholder="' . __('Width', 'imic-framework') . '" rel="' . $this->field['id'] . '-width" value="' . filter_var($this->value['width'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . '">';
            echo '<input data-id="' . $this->field['id'] . '" type="hidden" id="' . $this->field['id'] . '-width" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][width]" value="' . $this->value['width'] . '"></div>';
        endif;

        /**
          Height
         * */
        if ($this->field['height'] === true):
            if (!empty($this->value['height']) && strpos($this->value['height'], $this->value['units']) === false) {
                $this->value['height'] = filter_var($this->value['height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                if ($this->field['units'] !== false) {
                    $this->value['height'] .= $this->value['units'];
                }
            }
            echo '<div class="field-dimensions-input input-prepend">';
            echo '<span class="add-on"><i class="el-icon-resize-vertical icon-large"></i></span>';
            echo '<input type="text" class="imic-dimensions-input imic-dimensions-height mini' . $this->field['class'] . '" placeholder="' . __('height', 'imic-framework') . '" rel="' . $this->field['id'] . '-height" value="' . filter_var($this->value['height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . '">';
            echo '<input data-id="' . $this->field['id'] . '" type="hidden" id="' . $this->field['id'] . '-height" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][height]" value="' . $this->value['height'] . '"></div>';
        endif;

        /**
          Units
        **/

        // If units field is set and units field NOT false then
        // fill out the options object and show it, otherwise it's hidden
        // and the default units value will apply.
         
        if (isset($this->field['units']) && $this->field['units'] !== false){
            echo '<div class="select_wrapper dimensions-units" original-title="' . __('Units', 'imic-framework') . '">';
            echo '<select data-id="' . $this->field['id'] . '" data-placeholder="' . __('Units', 'imic-framework') . '" class="imic-dimensions imic-dimensions-units select' . $this->field['class'] . '" original-title="' . __('Units', 'imic-framework') . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][units]">';

            //  Extended units, show 'em all
            if ( $this->field['units_extended'] ) {
                    $testUnits = array('px', 'em', '%', 'in', 'cm', 'mm', 'ex', 'pt', 'pc');	
            } else {
                    $testUnits = array('px', 'em', '%');
            }
            
            if ( $this->field['units'] != "" && is_array( $this->field['units'] ) ) {
                    $testUnits = $this->field['units'];
            }
                                
            if (in_array($this->field['units'], $testUnits)) {
                echo '<option value="' . $this->field['units'] . '" selected="selected">' . $this->field['units'] . '</option>';
            } else {
                foreach ($testUnits as $aUnit) {
                    echo '<option value="' . $aUnit . '" ' . selected($this->value['units'], $aUnit, false) . '>' . $aUnit . '</option>';
                }
            }
            echo '</select></div>';
        };
        echo "</fieldset>";
    }

//function

    /**
     * Enqueue Function.
     *
     * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
     */
    function enqueue() {
        wp_enqueue_script('select2-js');
        wp_enqueue_style('select2-css');

        wp_enqueue_script(
                'imic-field-dimensions-js', IMIC_Framework::$_url . 'inc/fields/dimensions/field_dimensions.min.js', array('jquery', 'select2-js', 'jquery-numeric'), time(), true
        );

        wp_enqueue_style(
                'imic-field-dimensions-css', IMIC_Framework::$_url . 'inc/fields/dimensions/field_dimensions.css', time(), true
        );
    }

//function
}

//class
