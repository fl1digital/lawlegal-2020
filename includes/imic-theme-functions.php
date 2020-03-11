<?php
global $imic_data;
//custom css
function imic_head_css() {
    global $imic_data;
    $output = '';
    $custom_css = $imic_data['custom-css-code'];
    if ($custom_css <> '') {
        $output .= $custom_css . "\n";
    }
    // Output styles
    if ($output <> '') {
        $output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
        echo $output;
    }
}
add_action('wp_head', 'imic_head_css');
//Maintenance mode
function maintenace_mode() {
    if (!current_user_can('edit_themes') || !is_user_logged_in()) {
        wp_die('Under Maintenance - We will be right back!');
    }
}
?>
<?php
if ($imic_data['switch-maintenance'] == 1) {
    add_action('get_header', 'maintenace_mode');
}
/* Add Favicon
  /*----------------------------------------------------------------------------------- */
function imic_favicon() {
    global $imic_data;
    $favicon = $imic_data['custom_favicon']['thumbnail'];
    if ($favicon != '') {
        echo '<link rel="shortcut icon" href="' . $favicon . '"/>' . "\n";
    } else {
        ?>
        <link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory') ?>/images/favicon.ico" />
    <?php
    }
}
add_action('wp_head', 'imic_favicon');
/*-----------------------------------------------------------------------------------*/
/* Show custom script code in footer */
/*-----------------------------------------------------------------------------------*/
function imic_custom_script(){
	 global $imic_data;
    $output = '';
    $custom_js = $imic_data['custom-js-code'];
    if ($custom_js <> '') {
        $output .= $custom_js . "\n";
    }
    // Output script
    if ($output <> '') {
        $output = "<!-- Custom Js -->\n<script type=\"text/javascript\">\n" . $output . "</script>\n";
        echo $output;
    }
}
add_action('wp_footer','imic_custom_script');


