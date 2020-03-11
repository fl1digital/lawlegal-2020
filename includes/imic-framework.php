<?php
/**
 * The IMIC Framework Plugin
 *
 * A great way to start using the IMIC Framework immediately.
 * WordPress coding standards and PHP best practices have been kept.
 *
 * @package   framework
 * @author    IMICREATION TEAM <info@imicreation.com>
 * @link      http://www.imiceation.com
 *
 * @wordpress-plugin
 * Plugin Name: IMIC Framework
 * Plugin URI:  http://wordpress.org/plugins/imic-framework/
 * Description: IMIC is a simple, truly extensible options framework for WordPress themes and plugins.
 * Version:     3.1.0
 * Author:      IMICREATION Team
 * Author URI:  http://www.imicreation.com
 * Text Domain: imic-framework
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'class-imic-plugin.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'IMIC_FrameworkPlugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'IMIC_FrameworkPlugin', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'IMIC_FrameworkPlugin', 'get_instance' ) );
