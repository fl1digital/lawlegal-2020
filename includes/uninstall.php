<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   framework
 * @author    IMICREATION TEAM <info@imicreation.com>
 * @link      http://www.imicreation.com
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// TODO: Define uninstall functionality here