<?php
/**
 * The Header for our theme.
 */
?>
<!DOCTYPE html>
<!-- BEGIN html -->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
    <!-- BEGIN head -->
    <head>
        <!-- Meta Tags -->
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <!-- Title -->
        <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
        <!-- Dynamic Stylesheet -->
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/colours.php" type="text/css" media="screen" />
        <!-- RSS & Pingbacks -->
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php
        if (get_option('imic_feedburner')) {
            echo get_option('imic_feedburner');
        } else {
            bloginfo('rss2_url');
        }
        ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <!-- Theme Hook -->
<?php wp_head(); ?>
        
        <!-- END head -->
    </head>
    <body <?php body_class(); ?>>
        <!-- start header -->
        <div class="header">
            <?php
            global $imic_data;
            ?>
            <!-- start box -->
            <div class="box">
                <!-- start contact-info -->
                <div class="contact-info">
                    <span class="phone"><?php echo $imic_data['admin-number']; ?></span>
                    <span class="mail"><a href="mailto:<?php echo $imic_data['admin-email']; ?>"><?php echo $imic_data['admin-email']; ?></a></span>
                </div>
                <!-- end contact-info -->
                <!-- start logo -->
                <div class="logo">


                    <a href="<?php echo site_url(); ?>" title="<?php echo site_url(); ?>"><img src="<?php echo $imic_data['logo-upload']['thumbnail']; ?>" /></a>
                </div>
                <!-- end logo -->
                <!-- start search-box -->
                <div class="search-box">
<?php get_search_form(); ?>
                </div>
                <!-- end search-box -->
                <div class="clear"></div>
                <!-- start navigation -->
                <div class="navigation">
<?php wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'menu')); ?>
                </div>
                <!-- end navigation -->
            </div>
            <!-- end box -->
        </div>
        <!-- end header -->
