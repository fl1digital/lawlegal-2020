<?php
/**
  IMIC_Framework Sample Config File
  For full documentation, please visit http://imicreation.com/

  Most of your editing will be done in this section.

  Here you can override default values, uncomment args and change their values.
  No $args are required, but they can be overridden if needed.

 * */
$args = array();

$args['bg_imgs_path'] = get_template_directory_uri() . '/images/preset-bg-imgs/';
$args['opt_name'] = 'imic_options';
// For use with a tab example below
$tabs = array();

ob_start();

$ct = wp_get_theme();
$theme_data = $ct;
$item_name = $theme_data->get('Name');
$tags = $ct->Tags;
$screenshot = $ct->get_screenshot();
$class = $screenshot ? 'has-screenshot' : '';

$customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'framework'), $ct->display('Name'));
?>
<div id="current-theme" class="<?php echo esc_attr($class); ?>">
    <?php if ($screenshot) : ?>
        <?php if (current_user_can('edit_theme_options')) : ?>
            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
            </a>
        <?php endif; ?>
        <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
    <?php endif; ?>

    <h4>
        <?php echo $ct->display('Name'); ?>
    </h4>

    <div>
        <ul class="theme-info">
            <li><?php printf(__('By %s', 'framework'), $ct->display('Author')); ?></li>
            <li><?php printf(__('Version %s', 'framework'), $ct->display('Version')); ?></li>
            <li><?php echo '<strong>' . __('Tags', 'framework') . ':</strong> '; ?><?php printf($ct->display('Tags')); ?></li>
        </ul>
        <p class="theme-description"><?php echo $ct->display('Description'); ?></p>
        <?php
        if ($ct->parent()) {
            printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'framework'), $ct->parent()->display('Name'));
        }
        ?>

    </div>

</div>

<?php
$item_info = ob_get_contents();

ob_end_clean();

$sampleHTML = '';
if (file_exists(dirname(__FILE__) . '/info-html.html')) {
    /** @global WP_Filesystem_Direct $wp_filesystem  */
    global $wp_filesystem;
    if (empty($wp_filesystem)) {
        require_once(ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }
    $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
}

// BEGIN Sample Config
// Setting dev mode to true allows you to view the class settings/info in the panel.
// Default: true
$args['dev_mode'] = true;

// Set the icon for the dev mode tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['dev_mode_icon'] = 'info-sign';
// Set the class for the dev mode tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['dev_mode_icon_class'] = 'icon-large';

// Set a custom option name. Don't forget to replace spaces with underscores!
$args['opt_name'] = 'imic_data';

// Setting system info to true allows you to view info useful for debugging.
// Default: false
//$args['system_info'] = true;
// Set the icon for the system info tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['system_info_icon'] = 'info-sign';
// Set the class for the system info tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
//$args['system_info_icon_class'] = 'icon-large';

$theme = wp_get_theme();

$args['display_name'] = $theme->get('Name');
//$args['database'] = "theme_mods_expanded";
$args['display_version'] = $theme->get('Version');

// If you want to use Google Webfonts, you MUST define the api key.
$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

// Define the starting tab for the option panel.
// Default: '0';
//$args['last_tab'] = '0';
// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
// Default: 'standard'
//$args['admin_stylesheet'] = 'standard';
// Setup custom links in the footer for share icons
$args['share_icons']['twitter'] = array(
    'link' => 'https://twitter.com/imicreation',
    'title' => 'Follow me on Twitter',
    'img' => IMIC_Framework::$_url . 'assets/img/social/Twitter.png'
);
$args['share_icons']['facebook'] = array(
    'link' => 'https://www.facebook.com/imicreations',
    'title' => 'Join me on Facebook',
    'img' => IMIC_Framework::$_url . 'assets/img/social/Facebook.png'
);

// Enable the import/export feature.
// Default: true
//$args['show_import_export'] = false;
// Set the icon for the import/export tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: refresh
//$args['import_icon'] = 'refresh';
// Set the class for the import/export tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['import_icon_class'] = 'icon-large';

/**
 * Set default icon class for all sections and tabs
 * @since 3.0.9
 */
$args['default_icon_class'] = 'icon-large';


// Set a custom menu icon.
//$args['menu_icon'] = '';
// Set a custom title for the options page.
// Default: Options
$args['menu_title'] = __('Options', 'framework');

// Set a custom page title for the options page.
// Default: Options
$args['page_title'] = __('Options', 'framework');

// Set a custom page slug for options page (wp-admin/themes.php?page=***).
// Default: imic_options
$args['page_slug'] = 'imic_options';

$args['default_show'] = true;
$args['default_mark'] = '*';

// Set a custom page capability.
// Default: manage_options
//$args['page_cap'] = 'manage_options';
// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
// Default: menu
//$args['page_type'] = 'submenu';
// Set the parent menu.
// Default: themes.php
// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'options_general.php';
// Set a custom page location. This allows you to place your menu where you want in the menu order.
// Must be unique or it will override other items!
// Default: null
//$args['page_position'] = null;
// Set a custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';
// Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
// IMIC no longer ships with standard icons!
// Default: iconfont
//$args['icon_type'] = 'image';
// Disable the panel sections showing as submenu items.
// Default: true
//$args['allow_sub_menu'] = false;
// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
$args['help_tabs'][] = array(
    'id' => 'imic-opts-1',
    'title' => __('Theme Information 1', 'framework'),
    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'framework')
);
$args['help_tabs'][] = array(
    'id' => 'imic-opts-2',
    'title' => __('Theme Information 2', 'framework'),
    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'framework')
);

// Set the help sidebar for the options page.                                        
$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'framework');


// Add HTML before the form.
if (!isset($args['global_variable']) || $args['global_variable'] !== false) {
    if (!empty($args['global_variable'])) {
        $v = $args['global_variable'];
    } else {
        $v = str_replace("-", "_", $args['opt_name']);
    }
    $args['intro_text'] = sprintf(__('<p>Did you know that IMIC Framework sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'framework'), $v);
} else {
    $args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'framework');
}

// Add content after the form.
//$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'framework');
// Set footer/credit line.
//$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'framework');


$sections = array();

//Background Patterns Reader
$sample_patterns_path = IMIC_Framework::$_dir . '../sample/patterns/';
$sample_patterns_url = IMIC_Framework::$_url . '../sample/patterns/';
$sample_patterns = array();

if (is_dir($sample_patterns_path)) :

    if ($sample_patterns_dir = opendir($sample_patterns_path)) :
        $sample_patterns = array();

        while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

            if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                $name = explode(".", $sample_patterns_file);
                $name = str_replace('.' . end($name), '', $sample_patterns_file);
                $sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
            }
        }
    endif;
endif;
$sections[] = array(
    'icon' => 'el-icon-cogs',
    'icon_class' => 'icon-large',
    'title' => __('General Settings', 'framework'),
    'fields' => array(
        array(
            'id' => 'switch-maintenance',
            'type' => 'switch',
            'title' => __('Enable Maintenance', 'framework'),
            'subtitle' => __('Enable the themes in maintenance mode.', 'framework'),
            "default" => 0,
            'on' => 'Enabled',
            'off' => 'Disabled',
        ),
       
        array(
            'id' => 'custom_favicon',
            'type' => 'media',
            'compiler' => 'true',
            'title' => __('Custom favicon', 'framework'),
            'desc' => __('Upload a 16px x 16px Png/Gif image that will represent your website favicon', 'framework')
        ),
        array(
            'id' => 'tracking-code',
            'type' => 'textarea',
            'title' => __('Tracking Code', 'framework'),
            'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'framework'),
            'validate' => 'js',
            'desc' => 'Validate that it\'s javascript!',
        ),
        
    )
);

$sections[] = array(
    'icon' => 'el-icon-chevron-up',
    'title' => __('Header Options', 'framework'),
    'desc' => __('<p class="description">These are the options for the header.</p>', 'framework'),
    'fields' => array(
        array(
            'id' => 'logo-upload',
            'type' => 'media',
            'url' => true,
            'title' => __('Upload Logo', 'framework'),
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc' => __('Basic media uploader with disabled URL input field.', 'framework'),
            'subtitle' => __('Upload site logo to display in header.', 'framework'),
            'default' => array('url' => 'http://s.wordpress.org/style/images/codeispoetry.png'),
        ),
        
        array(
            'id' => 'admin-email',
            'type' => 'text',
            'title' => __('Admin Email', 'framework'),
            'subtitle' => __('Enter Admin Email Address', 'framework'),
            'validate' => 'email',
            'msg' => 'custom error message',
            'default' => 'test@test.com'
        ),
        array(
            'id' => 'admin-number',
            'type' => 'text',
            'title' => __('Contact Number', 'framework'),
            'subtitle' => __('Enter  phone number to display as contact number.', 'framework'),
            'desc' => __('Enter  phone number to display as contact number.', 'framework')
        ),
    ),
);

$sections[] = array(
    'icon' => 'el-icon-chevron-down',
    'title' => __('Footer Options', 'framework'),
    'desc' => __('<p class="description">These are the options for the footer.</p>', 'framework'),
    'fields' => array(
        array(
            'id' => 'footer-text',
            'type' => 'editor',
            'title' => __('Footer Text 1', 'framework'),
            'subtitle' => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'framework'),
            'default' => 'Powered by [wp-url]. Built on the [theme-url].',
        ),
        array(
            'id' => 'footer-text-2',
            'type' => 'editor',
            'title' => __('Footer Text 2', 'framework'),
            'subtitle' => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'framework'),
            'default' => 'Powered by [wp-url]. Built on the [theme-url].',
        ),
    ),
   
);



$sections[] = array(
    'icon' => 'el-icon-edit',
    'title' => __('Custom HTML/CSS/JS', 'framework'),
    'fields' => array(
        array(
            'id' => 'custom-html-code',
            'type' => 'textarea',
            'title' => __('Custom HTML', 'framework'),
            'subtitle' => __('Just like a text box widget.', 'framework'),
            'desc' => __('This field is even HTML validated!', 'framework'),
            'validate' => 'html',
        ),
        array(
            'id' => 'custom-css-code',
            'type' => 'ace_editor',
            //'required' => array('layout','equals','1'),	
            'title' => __('CSS Code', 'framework'),
            'subtitle' => __('Paste your CSS code here.', 'framework'),
            'mode' => 'css',
            'theme' => 'monokai',
            'desc' => '',
            'default' => "#header{\nmargin: 0 auto;\n}"
        ),
        array(
            'id' => 'custom-js-code',
            'type' => 'ace_editor',
            //'required' => array('layout','equals','1'),	
            'title' => __('JS Code', 'framework'),
            'subtitle' => __('Paste your JS code here.', 'framework'),
            'mode' => 'javascript',
            'theme' => 'chrome',
            'desc' => '',
            'default' => "jQuery(document).ready(function(){\n\n});"
        )
    ),
);



if (function_exists('wp_get_theme')) {
    $theme_data = wp_get_theme();
    $theme_uri = $theme_data->get('ThemeURI');
    $description = $theme_data->get('Description');
    $author = $theme_data->get('Author');
    $version = $theme_data->get('Version');
    $tags = $theme_data->get('Tags');
} else {
    $theme_data = wp_get_theme(trailingslashit(get_stylesheet_directory()) . 'style.css');
    $theme_uri = $theme_data['URI'];
    $description = $theme_data['Description'];
    $author = $theme_data['Author'];
    $version = $theme_data['Version'];
    $tags = $theme_data['Tags'];
}

$theme_info = '<div class="framework-section-desc">';
$theme_info .= '<p class="framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'framework') . '<a href="' . $theme_uri . '" target="_blank">' . $theme_uri . '</a></p>';
$theme_info .= '<p class="framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'framework') . $author . '</p>';
$theme_info .= '<p class="framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'framework') . $version . '</p>';
$theme_info .= '<p class="framework-theme-data description theme-description">' . $description . '</p>';
if (!empty($tags)) {
    $theme_info .= '<p class="framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'framework') . implode(', ', $tags) . '</p>';
}
$theme_info .= '</div>';

if (file_exists(dirname(__FILE__) . '/README.md')) {
    $sections['theme_docs'] = array(
        'icon' => IMIC_Framework::$_url . 'assets/img/glyphicons/glyphicons_071_book.png',
        'title' => __('Documentation', 'framework'),
        'fields' => array(
            array(
                'id' => '17',
                'type' => 'raw',
                'content' => file_get_contents(dirname(__FILE__) . '/README.md')
            ),
        ),
    );
}//if
$sections[] = array(
    'icon' => 'el-icon-info-sign',
    'title' => __('Theme Information', 'framework'),
    'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'framework'),
    'fields' => array(
        array(
            'id' => 'raw_new_info',
            'type' => 'raw',
            'content' => $item_info,
        )
    ),
);



if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
    $tabs['docs'] = array(
        'icon' => 'el-icon-book',
        'icon_class' => 'icon-large',
        'title' => __('Documentation', 'framework'),
        'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
    );
}
global $IMIC_Framework;
$IMIC_Framework = new IMIC_Framework($sections, $args, $tabs);
// END Sample Config

/**

  Custom function for filtering the sections array. Good for child themes to override or add to the sections.
  Simply include this function in the child themes functions.php file.

  NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
  so you must use get_template_directory_uri() if you want to use any of the built in icons

 * */
// replace imic_data with your opt_name

/**

  Filter hook for filtering the args array given by a theme, good for child themes to override or add to the args array.

 * */
function change_framework_args($args) {
    //$args['dev_mode'] = true;

    return $args;
}

add_filter('imic/options/imic_data/args', 'change_framework_args');
// replace imic_data with your opt_name

/**

  Filter hook for filtering the default value of any given field. Very useful in development mode.

 * */
function change_option_defaults($defaults) {
    $defaults['str_replace'] = "Testing filter hook!";

    return $defaults;
}

add_filter('imic/options/imic_data/defaults', 'change_option_defaults');
// replace imic_data with your opt_name

/**

  Custom function for the callback referenced above

 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

/**

  Custom function for the callback validation referenced above

 * */
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value = 'just testing';
    /*
      do your validation

      if(something) {
      $value = $value;
      } elseif(something else) {
      $error = true;
      $value = $existing_value;
      $field['msg'] = 'your custom error message';
      }
     */

    $return['value'] = $value;
    if ($error == true) {
        $return['error'] = $field;
    }
    return $return;
}

/**

  This is a test function that will let you see when the compiler hook occurs.
  It only runs if a field	set with compiler=>true is changed.

 * */
function testCompiler() {
    echo "Compiler hook!";
}

//add_filter('imic/options/imic_data/compiler', 'testCompiler');
// replace imic_data with your opt_name




/**

  Used to hide the activation notice informing users of the demo panel. Only used when IMIC is a plugin.

 * */
if (class_exists('IMIC_FrameworkPlugin')) {
    //remove_action('admin_notices', array( IMIC_FrameworkPlugin::get_instance(), 'admin_notices' ) );	
}

/**

  Used to hide the demo mode link from the plugin page. Only used when IMIC is a plugin.

 * */
function removeDemoModeLink() {
    if (class_exists('IMIC_FrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(IMIC_FrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
    }
}

//add_action('init', 'removeDemoModeLink');




