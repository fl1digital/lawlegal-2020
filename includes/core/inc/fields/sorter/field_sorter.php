<?php
/**
 * Options Sorter Field for IMIC Options
 * @author  IMICREATION<info@imicreation.com>
 * @url     
 * @license 
 *
 * Original Credits:
 * Author		: 
 * Author URI   	: 
 * License		: GPLv3 - 
 * Credits		: Thematic Options Panel - 
  KIA Thematic Options Panel -
  Woo Themes - 
  Option Tree - 
 * Twitter: 
 * Website: 
 */
class IMIC_Framework_sorter extends IMIC_Framework {

    /**
     * Field Constructor.
     * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
     */
    function __construct($field = array(), $value = '', $parent) {
        parent::__construct($parent->sections, $parent->args);
        $this->field = $field;
        $this->value = $value;
        if (!is_array($this->value) && isset($this->field['options'])) {
            $this->value = $this->field['options'];
        }
    }

    /**
     * Field Render Function.
     * Takes the vars and outputs the HTML for the field in the settings
     * @since 1.0.0
     */
    function render() {

		// Make sure to get list of all the default blocks first
	    $all_blocks = !empty( $this->field['options'] ) ? $this->field['options'] : array();

	    $temp = array(); // holds default blocks
	    $temp2 = array(); // holds saved blocks

		foreach($all_blocks as $blocks) {
		    $temp = array_merge($temp, $blocks);
		}

	    $sortlists = $this->value;

	    if ( is_array( $sortlists ) ) {
		    foreach( $sortlists as $sortlist ) {
				$temp2 = array_merge($temp2, $sortlist);
		    }

		    // now let's compare if we have anything missing
		    foreach($temp as $k => $v) {
				if(!array_key_exists($k, $temp2)) {
				    $sortlists['disabled'][$k] = $v;
				}
		    }

		    // now check if saved blocks has blocks not registered under default blocks
		    foreach( $sortlists as $key => $sortlist ) {
				foreach($sortlist as $k => $v) {
				    if(!array_key_exists($k, $temp)) {
					unset($sortlist[$k]);
				    }
				}
				$sortlists[$key] = $sortlist;
		    }

		    // assuming all sync'ed, now get the correct naming for each block
		    foreach( $sortlists as $key => $sortlist ) {
				foreach($sortlist as $k => $v) {
				    $sortlist[$k] = $temp[$k];
				}
				$sortlists[$key] = $sortlist;
		    }

			

			    if ($sortlists) {
			    	echo '<fieldset id="'.$this->field['id'].'" class="imic-sorter-container sorter">';

					foreach ($sortlists as $group=>$sortlist) {

					    echo '<ul id="'.$this->field['id'].'_'.$group.'" class="sortlist_'.$this->field['id'].'">';
					    echo '<h3>'.$group.'</h3>';

					    foreach ($sortlist as $key => $list) {

							echo '<input class="sorter-placebo" type="hidden" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $group . '][placebo]" value="placebo">';

							if ($key != "placebo") {

							    echo '<li id="'.$key.'" class="sortee">';
							    echo '<input class="position '.$this->field['class'].'" type="hidden" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $group . '][' . $key . ']" value="'.$list.'">';
							    echo $list;
							    echo '</li>';

							}

					    }

					    echo '</ul>';
					}
					echo '</fieldset>';
			    }
		    }

	        
        
    }

    function enqueue() {
        wp_register_script('options-sorter', IMIC_Framework::$_url . 'inc/fields/sorter/field_sorter.min.js', array(
            'jquery'));
        wp_register_style('options-sorter', IMIC_Framework::$_url . 'inc/fields/sorter/field_sorter.css');
        wp_enqueue_script('options-sorter');
        wp_enqueue_style('options-sorter');
    }

}
