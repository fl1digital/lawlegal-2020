<?php

/* 	Register and load common JS
  /*----------------------------------------------------------------------------------- */

function imic_enqueue_scripts() {
    // Register our scripts
    wp_register_script('imi_jquerymin', get_template_directory_uri() . '/js/jquery1.7.1.js', 'jquery');
    wp_register_style('imi_stylesheet', get_template_directory_uri() . '/style.css?v=1.2');
    wp_register_script('imi_main', get_template_directory_uri() . '/js/main.js', 'jquery');
    // Enqueue our scripts
    wp_enqueue_script('imi_jquerymin');
    wp_enqueue_style('imi_stylesheet');
    wp_enqueue_script('imi_main');
    if (is_singular()) {
        wp_enqueue_script('comment-reply');
    } // loads the javascript required for threaded comments 
}
add_action('wp_enqueue_scripts', 'imic_enqueue_scripts');
/* ----------------------------------------------------------------------------------- */
/*
 * Include Framework
 */
require_once(IMIC_FILEPATH . '/includes/core/framework.php');
require_once(IMIC_FILEPATH . '/includes/sample/sample-config.php');
require_once(IMIC_FILEPATH . '/includes/imic-theme-functions.php');

// To upload Client Image 
require_once 'Gallery/GalleryWidget.php';
?>
