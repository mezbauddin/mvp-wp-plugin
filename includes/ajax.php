<?php
add_action('wp_enqueue_scripts', function () {
    if (is_admin()) return;
    if (!get_option('mvp_consent_given', false)) return;
    wp_enqueue_script('mvp-click-tracker', plugin_dir_url(__FILE__) . '../assets/click-tracker.js', ['jquery'], null, true);
    wp_localize_script('mvp-click-tracker', 'mvp_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mvp_click_nonce')
    ]);
    wp_enqueue_script('mvp-link-tracker', plugin_dir_url(__FILE__) . '../assets/link-tracker.js', [], null, true);
    wp_localize_script('mvp-link-tracker', 'mvp_settings', [
        'mvp_id' => get_option('mvp_tracking_id', '')
    ]);
});

add_action('wp_ajax_nopriv_mvp_log_click', 'mvp_log_click');
add_action('wp_ajax_mvp_log_click', 'mvp_log_click');

function mvp_log_click() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'mvp_click_nonce')) {
        wp_send_json_error(esc_html__('Invalid security token', 'mvp-link-tracker-and-analytics'), 403);
    }

    global $wpdb;
    $url = isset($_POST['url']) ? esc_url_raw(wp_unslash($_POST['url'])) : '';
    $table = $wpdb->prefix . 'mvp_clicks';
    $wpdb->insert($table, ['url' => $url]);
    wp_send_json_success(['message' => esc_html__('Click logged', 'mvp-link-tracker-and-analytics')]);
}
