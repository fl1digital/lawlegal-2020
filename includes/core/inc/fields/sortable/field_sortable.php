<?php
class IMIC_Framework_sortable {

    /**
     * Field Constructor.
     *
     * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
    */
    function __construct($field = array(), $value ='', $parent) {
        $this->field = $field;
        $this->value = $value;
        $this->args = $parent->args;
    }

    /**
     * Field Render Function.
     *
     * Takes the vars and outputs the HTML for the field in the settings
    */
    function render() {

        if ( empty( $this->field['mode'] ) ) {
            $this->field['mode'] = "text";
        }

        if ( $this->field['mode'] != "checkbox" && $this->field['mode'] != "text"  ) {
            $this->field['mode'] = "text";
        }       

        $class = (isset($this->field['class'])) ? $this->field['class'] : '';
        $options = $this->field['options'];

        if (!empty($this->value)) {
            foreach ($this->value as $k=>$v) {
                if (!isset($options[$k])) {
                    unset($this->value[$k]);
                }
            }
        }

        foreach ($options as $k=>$v) {
            if (!isset($this->value[$k])) {
                $this->value[$k] = $v;
            }
        }


        echo '<ul id="'.$this->field['id'].'-list" class="imic-sortable ' . $class . '">';

        foreach ($this->value as $k => $nicename) {
            $value_display = isset($this->value[$k]) ? $this->value[$k] : '';
            echo '<li>';
            
            $checked = "";
            $name = $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $k . ']';

            if ( $this->field['mode'] == "checkbox") {
                if (!empty($this->value[$k])) {
                    $checked = 'checked="checked" ';
                }
                $class .= " checkbox_sortable";

                echo '<input type="hidden" name="'.$name.'" id="'.$this->field['id'].'-'.$k.'-hidden" value="'.$value_display.'" />';
                $name = "";
            }
            if ( $this->field['mode'] == "checkbox") {
                echo '<div class="checkbox-container">';
            }
            echo '<input rel="'.$this->field['id'].'-'.$k.'-hidden" class="' . $class . '" '.$checked.'type="'.$this->field['mode'].'" id="' . $this->field['id'] . '[' . $k . ']" name="'.$name.'" value="' . esc_attr($value_display) . '" placeholder="' . $nicename . '" />';

            echo '<span class="compact drag"><i class="el-icon-move icon-large"></i></span>';
            if ( $this->field['mode'] == "checkbox" || (isset( $this->field['label'] ) && $this->field['label'] == true ) ) {
                if ( $this->field['mode'] != "checkbox" ) {
                    echo "<br />";
                }
                echo '<label for="' . $this->field['id'] . '[' . $k . ']"><strong>' . $options[$k] . '</strong></label>';

            }
            if ( $this->field['mode'] == "checkbox") {
                echo '</div>';
            }
            echo '</li>';
        }
        echo '</ul>';
            
    }

    function enqueue() {

        wp_enqueue_script(
            'imic-field-sortable-js',
            IMIC_Framework::$_url . 'inc/fields/sortable/field_sortable.min.js',
            array('jquery'),
            time(),
            true
        );


        wp_enqueue_style(
            'imic-field-sortable-css', 
            IMIC_Framework::$_url.'inc/fields/sortable/field_sortable.css', 
            time(),
            true
        );  

    }
}