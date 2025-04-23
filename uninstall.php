<?php
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

global $wpdb;
// Remove plugin options
delete_option('mvp_tracking_id');
delete_option('mvp_consent_given');
// Drop click tracking table
$table = $wpdb->prefix . 'mvp_clicks';
if (preg_match('/^[a-zA-Z0-9_]+$/', $table)) { // basic validation
    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.SchemaChange -- Table name only, safe usage for uninstall routine.
    $wpdb->query("DROP TABLE IF EXISTS $table");
}
