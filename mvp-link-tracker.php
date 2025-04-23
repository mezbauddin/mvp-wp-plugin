<?php
/*
Plugin Name: MVP Link Tracker
Description: Append your MVP WT.mc_id to Microsoft links, track clicks, and manage renewal insights.
Version: 2.0.1
Author: Mezba Uddin
Author URI: https://profiles.wordpress.org/mrmicrosoft/
Requires at least: 6.5
Tested up to: 6.8
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: mvp-link-tracker-and-analytics
*/

if (!defined('ABSPATH')) exit;

define('MVP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MVP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load all plugin components early so callbacks are registered properly
require_once MVP_PLUGIN_PATH . 'includes/dashboard.php';
require_once MVP_PLUGIN_PATH . 'includes/settings.php';
require_once MVP_PLUGIN_PATH . 'includes/stats.php';
require_once MVP_PLUGIN_PATH . 'includes/bulk.php';
require_once MVP_PLUGIN_PATH . 'includes/frontend.php';
require_once MVP_PLUGIN_PATH . 'includes/db.php';
require_once MVP_PLUGIN_PATH . 'includes/ajax.php';

add_action('admin_menu', function() {
    add_menu_page('Microsoft MVP Dashboard', 'Microsoft MVP', 'manage_options', 'mvp-dashboard', 'mvp_render_dashboard', 'dashicons-awards', 90);
    add_submenu_page('mvp-dashboard', 'Dashboard', 'Dashboard', 'manage_options', 'mvp-dashboard', 'mvp_render_dashboard');
    add_submenu_page('mvp-dashboard', 'Settings', 'Settings', 'manage_options', 'mvp-settings', 'mvp_render_settings');
    add_submenu_page('mvp-dashboard', 'Click Stats', 'Click Stats', 'manage_options', 'mvp-stats', 'mvp_render_stats');
    add_submenu_page('mvp-dashboard', 'Bulk Updater', 'Bulk Updater', 'manage_options', 'mvp-bulk', 'mvp_render_bulk');
});
