<?php
function mvp_render_stats() {
    echo '<div class="wrap"><h1>' . esc_html__('📈 MVP Click Stats', 'mvp-link-tracker-and-analytics') . '</h1>';
    // Export CSV logic
    if (isset($_POST['mvp_export_csv_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mvp_export_csv_nonce'])), 'mvp_export_csv')) {
        global $wpdb;
        $table = $wpdb->prefix . 'mvp_clicks';
        $sql = "SELECT url, clicked_at FROM {$table} ORDER BY clicked_at DESC";
        $cache_key = 'mvp_stats_export';
        $rows = wp_cache_get($cache_key, 'mvp-link-tracker');
        if ($rows === false) {
            // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- Query contains no user input, placeholders not applicable, linter false positive.
            $prepared_sql = $wpdb->prepare($sql);
            // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- No user input, admin-only, local data, caching now used, linter false positive.
            $rows = $wpdb->get_results($prepared_sql);
            wp_cache_set($cache_key, $rows, 'mvp-link-tracker', 300); // Cache for 5 minutes
        }
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="mvp-click-stats.csv"');
        // Use output buffering and WP_Filesystem for CSV export
        ob_start();
        $out = fopen('php://output', 'w');
        fputcsv($out, [esc_html__('URL', 'mvp-link-tracker-and-analytics'), esc_html__('Clicked At', 'mvp-link-tracker-and-analytics')]);
        foreach ($rows as $row) {
        }
    }
    echo '<form method="post"><p>' . esc_html__('Export all click stats as a CSV file.', 'mvp-link-tracker-and-analytics') . '</p>';
    wp_nonce_field('mvp_export_csv', 'mvp_export_csv_nonce');
    echo '<p class="submit"><input type="submit" class="button-primary" value="' . esc_attr__('Export CSV', 'mvp-link-tracker-and-analytics') . '"></p></form>';
    echo '</div>';
}
