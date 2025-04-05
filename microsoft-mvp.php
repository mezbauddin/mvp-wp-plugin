<?php
/*
Plugin Name: Microsoft MVP
Description: Append MVP ID to Microsoft links + click tracking + bulk tools.
Version: 2.0.1
Author: Mezba Uddin
Requires at least: 6.5
Tested up to: 6.5
Requires PHP: 7.4
*/

if (!defined('ABSPATH')) exit;

define('MVP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MVP_PLUGIN_URL', plugin_dir_url(__FILE__));

add_action('admin_menu', function() {
    add_menu_page('Microsoft MVP Dashboard', 'Microsoft MVP', 'manage_options', 'mvp-dashboard', 'mvp_render_dashboard', 'dashicons-awards', 90);
    add_submenu_page('mvp-dashboard', 'Dashboard', 'Dashboard', 'manage_options', 'mvp-dashboard', 'mvp_render_dashboard');
    add_submenu_page('mvp-dashboard', 'Settings', 'Settings', 'manage_options', 'mvp-settings', 'mvp_render_settings');
    add_submenu_page('mvp-dashboard', 'Click Stats', 'Click Stats', 'manage_options', 'mvp-stats', 'mvp_render_stats');
    add_submenu_page('mvp-dashboard', 'Bulk Updater', 'Bulk Updater', 'manage_options', 'mvp-bulk', 'mvp_render_bulk');
});

include_once MVP_PLUGIN_PATH . 'includes/dashboard.php';
include_once MVP_PLUGIN_PATH . 'includes/settings.php';
include_once MVP_PLUGIN_PATH . 'includes/stats.php';
include_once MVP_PLUGIN_PATH . 'includes/bulk.php';
include_once MVP_PLUGIN_PATH . 'includes/frontend.php';
include_once MVP_PLUGIN_PATH . 'includes/db.php';
include_once MVP_PLUGIN_PATH . 'includes/ajax.php';
