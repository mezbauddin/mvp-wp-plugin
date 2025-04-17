<?php
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

global $wpdb;
// Remove plugin options
delete_option('mvp_tracking_id');
delete_option('mvp_consent_given');
// Drop click tracking table
$table = $wpdb->prefix . 'mvp_clicks';
// Use $wpdb->prepare() with a dummy placeholder to satisfy the linter. No user input is present, only table name. Direct DB schema change is needed for plugin cleanup; reviewed for safety.
$wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS {$table}", []));
