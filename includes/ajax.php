<?php
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('mvp-click-tracker', plugin_dir_url(__FILE__) . '../assets/click-tracker.js', ['jquery'], null, true);
    wp_localize_script('mvp-click-tracker', 'mvp_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mvp_click_nonce')
    ]);
});

add_action('wp_ajax_nopriv_mvp_log_click', 'mvp_log_click');
add_action('wp_ajax_mvp_log_click', 'mvp_log_click');

function mvp_log_click() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mvp_click_nonce')) {
        wp_send_json_error('Invalid security token', 403);
    }

    global $wpdb;
    $url = esc_url_raw($_POST['url']);
    $table = $wpdb->prefix . 'mvp_clicks';
    $wpdb->insert($table, ['url' => $url]);
    wp_send_json_success(['message' => 'Click logged']);
}
