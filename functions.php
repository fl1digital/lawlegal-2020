<?php
/* -----------------------------------------------------------------------------------
  Here we have all the custom functions for the theme
  Please be extremely cautious editing this file,
  When things go wrong, they tend to go wrong in a big way.
  You have been warned!
  ----------------------------------------------------------------------------------- */
  /*----------------------------------------------------------------------------------- */
define('IMIC_FILEPATH', get_template_directory());
define('IMIC_DIRECTORY', get_template_directory_uri());
/* ----------------------------------------------------------------------------------- */
/* 	Load Translation Text Domain
  /*----------------------------------------------------------------------------------- */
function imic_theme_setup() {
    load_theme_textdomain('framework', IMIC_FILEPATH . '/language/');
}
add_action('after_setup_theme', 'imic_theme_setup');
/* 	Register WP3.0+ Menus
  /*----------------------------------------------------------------------------------- */
function register_menu() {
    register_nav_menu('primary-menu', __('Primary Menu', 'framework'));
}
add_action('init', 'register_menu');
/* ----------------------------------------------------------------------------------- */
/* 	Set Max Content Width (use in conjuction with ".entry-content img" css)
  /*----------------------------------------------------------------------------------- */
if (!isset($content_width))
    $content_width = 680;
/* ----------------------------------------------------------------------------------- */
/* 	Register Sidebars
  /*----------------------------------------------------------------------------------- */
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => __('Client Logo', 'framework'),
        'id' => 'client_logo',
        'description' => '',
        'class' => '',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
    ));
}
/* ----------------------------------------------------------------------------------- */
/* 	Configure WP2.9+ Thumbnails
  /*----------------------------------------------------------------------------------- */
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(958, 9999);
}
/* ----------------------------------------------------------------------------------- */
/* 	Custom Gravatar Support
  /*----------------------------------------------------------------------------------- */
function imic_custom_gravatar($avatar_defaults) {
    $imic_avatar = get_template_directory_uri() . '/images/gravatar.png';
    $avatar_defaults[$imic_avatar] = 'Custom Gravatar (/images/gravatar.png)';
    return $avatar_defaults;
}
add_filter('avatar_defaults', 'imic_custom_gravatar');
/* ----------------------------------------------------------------------------------- */
/* 	Helpful function to see if a number is a multiple of another number
  /*----------------------------------------------------------------------------------- */
function is_multiple($number, $multiple) {
    return ($number % $multiple) == 0;
}
/* 	Load Widgets & Shortcodes
  /*----------------------------------------------------------------------------------- */
function pagination($pages = '', $range = 4) {
    $showitems = ($range * 2) + 1;
    global $paged;
    if (empty($paged))
        $paged = 1;
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    if (1 != $pages) {
        //echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
        echo '<ul>';
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
            echo "<a href='" . get_pagenum_link(1) . "'>&laquo; First</a>";
        if ($paged > 1 && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo; Previous</a>";

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<li class=\"active\">" . $i . "</li>" : "<li><a href='" . get_pagenum_link($i) . "' class=\"\">" . $i . "</a></li>";
            }
        }
        if ($paged < $pages && $showitems < $pages)
            echo "<li><a href=\"" . get_pagenum_link($paged + 1) . "\">Next &rsaquo;</a></li>";
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link($pages) . "'>Last &raquo;</a></li>";
        //echo "</div>\n";
        echo '</ul>';
    }
}
function limited_content($content_length = 250, $allowtags = true, $allowedtags = '') {
    global $post;
    $content = $post->post_content;
    $content = apply_filters('the_content', $content);
    if (!$allowtags) {
        $allowedtags .= '<style>';
        $content = strip_tags($content, $allowedtags);
    }
    $wordarray = explode(' ', $content, $content_length + 1);
    if (count($wordarray) > $content_length) :
        array_pop($wordarray);
        array_push($wordarray, '…');
        $content = implode(' ', $wordarray);
        $content .= "</p>";
    endif;
    echo $content;
}
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
function remove_thumbnail_dimensions($html) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
include_once('imic-framework.php');



