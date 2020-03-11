<?php
/**
 * IMIC Framework Plugin Class
 *
 * @package   framework
 * @author    IMICREATION <info@imicreation.com>
 * @link      http://www.imicreation.com
 */

/**
 * Plugin class.
 *
 * TODO: Rename this class to a proper name for your plugin.
 *
 * @package IMICFrameworkPlugin
 * @author  IMICREATION <info@imicreation.com>
 */

class IMIC_FrameworkPlugin {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * Array of config options saved in the DB
	 *
	 * Used to determine if demo mode is activated.
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $options = array();		

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'imic-framework';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Network activated plugins
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_network_activated = false;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		$defaults = array(
						'demo'			=> false, 
					);
		// Grabbing the options if plugin is network activated
		if ( is_multisite() ) {
			$plugins = get_site_option( 'active_sitewide_plugins');
			foreach($plugins as $file => $k) {
				if ( strpos($file,'imic-framework.php') !== false ) {
					$this->plugin_network_activated = true;
					$this->options = get_site_option( 'IMIC_FrameworkPlugin', $defaults );
				}
			}
		}
		if ( empty($this->options) ) {
			$this->options = get_option( 'IMIC_FrameworkPlugin', $defaults );
		}

		add_action( 'wp_loaded', array( $this, 'imic_options_toggle_check' )  );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		add_action('admin_notices', array( $this, 'admin_notices' ) );

		add_filter( 'plugin_row_meta', array($this, 'plugin_meta_links'), null, 2 );
		add_filter( 'plugin_row_meta', array($this, 'plugin_meta_demo_mode_link'), null, 2 );

		if ( file_exists( dirname( __FILE__ ) . '/core/framework.php' ) ) {
			require_once( dirname( __FILE__ ) . '/core/framework.php' );
		}

		
		if ($this->options['demo'] && file_exists( dirname( __FILE__ ) . '/sample/sample-config.php' ) ) {
			require_once( dirname( __FILE__ ) . '/sample/sample-config.php' );
		}

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide  ) {
				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::single_activate();
				}
				restore_current_blog();
			} else {
				self::single_activate();
			}
		} else {
			self::single_activate();
		}
		delete_site_transient('update_plugins');
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::single_deactivate();
				}
				restore_current_blog();
			} else {
				self::single_deactivate();
			}
		} else {
			self::single_deactivate();
		}
		delete_option( 'IMIC_FrameworkPlugin');
	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param	int	$blog_id ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {
		if ( 1 !== did_action( 'wpmu_new_blog' ) )
			return;

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return	array|false	The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {
		/** @global wpdb $wpdb */
		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

        return $wpdb->get_col( $sql );
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
			$notices = get_option('IMIC_FrameworkPlugin_ACTIVATED_NOTICES', array());
			$notices[]= __("IMIC Framework has an embedded demo.", 'imic-framework').' <a href="./plugins.php?IMIC_FrameworkPlugin=demo">'.__("Click here to activate the sample config file.", 'imic-framework')."</a>";
			update_option('IMIC_FrameworkPlugin_ACTIVATED_NOTICES', $notices);			
	}


	public function admin_notices() {
		do_action('IMIC_FrameworkPlugin_admin_notice');
		if ($notices= get_option('IMIC_FrameworkPlugin_ACTIVATED_NOTICES')) {
			foreach ($notices as $notice) {
				echo "<div class='updated'><p>$notice</p></div>";
			}
			delete_option('IMIC_FrameworkPlugin_ACTIVATED_NOTICES');
		}
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		delete_option('IMIC_FrameworkPlugin_ACTIVATED_NOTICES');
	}

	/**
	 * Turn on or off
	 *
	 * @since    1.0.0
	 */
	public function IMIC_options_toggle_check() {
		global $pagenow;

		if ( $pagenow == "plugins.php" && is_admin() && !empty( $_GET['IMIC_FrameworkPlugin'] ) ) {
			$url = "./plugins.php";

			if ( $_GET['IMIC_FrameworkPlugin'] == 'demo') {
				if ( $this->options['demo'] == false ) {
					$this->options['demo'] = true;
				} else {
					$this->options['demo'] = false;
				}
			}
			if ( is_multisite() && is_network_admin() && $this->plugin_network_activated ) {
				update_site_option( 'IMIC_FrameworkPlugin', $this->options );
			} else {
				update_option( 'IMIC_FrameworkPlugin', $this->options );	
			}
			wp_redirect( $url );

		}

	}	

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {
		// In case we ever want to do that...
		return $links;
		/*
		return array_merge(
			array('imic_plugin_settings' => '<a href="' . admin_url( 'plugins.php?page=' . 'imic_plugin_settings' ) . '">' . __('Settings', 'imic-framework') . '</a>'),
			$links
		);
		*/
	}

	/**
	 * @param array $links
	 * @param string $file
	 * @return array
	 * @wp-hook plugin_row_meta
	 */
	function plugin_meta_links( $links, $file ) {
		if ( strpos($file,'imic-framework.php') === false ) {
    		return $links;
		}

		$plugin = str_replace('class-imic-plugin', 'imic-framework', plugin_basename(__FILE__));
		$array = array( '', '' );
		// create link
		if ( $file == $plugin ) {
			return array_merge(
				$links,
				$array
			);
		}
		return $links;
	 
	}

	/**
	 * @param array $links
	 * @param string $file
	 * @return array
	 * @wp-hook plugin_row_meta
	 */
	function plugin_meta_demo_mode_link( $links, $file ) {
		if ( strpos($file,'imic-framework.php') === false ) {
    		return $links;
		}

	 	$extra = '<br /><span style="display: block; padding-top: 6px;">';
		
		if ($this->options['demo']) {
			$demoText = '<a href="./plugins.php?IMIC_FrameworkPlugin=demo" style="color: #bc0b0b;">' . __( 'Deactivate Demo Mode', $this->plugin_slug ) . '</a>';
		} else {
			$demoText = '<a href="./plugins.php?IMIC_FrameworkPlugin=demo">' . __( 'Activate Demo Mode', $this->plugin_slug ) . '</a>';
		}
		

		if ( is_multisite() && $this->plugin_network_activated || !is_network_admin() || !is_multisite()) {
			$extra .= $demoText;
		}

		$extra .='</span>';

		$plugin = str_replace('class-imic-plugin', 'imic-framework', plugin_basename(__FILE__));
		// create link
		if ( $file == $plugin ) {
			$links[count($links)-1] .= $extra;
		}
		return $links;
	 
	}		


}
