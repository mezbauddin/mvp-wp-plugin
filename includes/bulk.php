<?php
function mvp_render_bulk() {
    echo '<div class="wrap"><h1>' . esc_html__('🛠️ Bulk Updater', 'mvp-link-tracker-and-analytics') . '</h1>';
    if (isset($_POST['mvp_bulk_update_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mvp_bulk_update_nonce'])), 'mvp_bulk_update')) {
        global $wpdb;
        $mvp_id = get_option('mvp_tracking_id', '');
        if (!$mvp_id) {
            echo '<div class="error"><p>' . esc_html__('Please set your MVP Tracking ID in Settings first.', 'mvp-link-tracker-and-analytics') . '</p></div>';
        } else {
            $posts = $wpdb->get_results("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'post'");
            $updated = 0; $links = 0;
            foreach ($posts as $post) {
                $content = $post->post_content;
                $new_content = preg_replace_callback('/<a[^>]+href=["\']([^"\']*microsoft\.com[^"\']*|[^"\']*aka\.ms[^"\']*)["\'][^>]*>/i', function($matches) use ($mvp_id, &$links) {
                    $url = $matches[1];
                    if (strpos($url, 'WT.mc_id=') === false) {
                        $links++;
                        $sep = (strpos($url, '?') === false) ? '?' : '&';
                        $url .= $sep . 'WT.mc_id=' . urlencode($mvp_id);
                        return str_replace($matches[1], $url, $matches[0]);
                    }
                    return $matches[0];
                }, $content);
                if ($content !== $new_content) {
                    wp_update_post(['ID' => $post->ID, 'post_content' => $new_content]);
                    $updated++;
                }
            }
            // translators: %1$d: Number of posts updated, %2$d: Number of links modified.
            echo '<div class="updated"><p>' . sprintf(esc_html__('Bulk update complete: %1$d post(s) updated, %2$d link(s) modified.', 'mvp-link-tracker-and-analytics'), esc_html($updated), esc_html($links)) . '</p></div>';
        }
    }
    echo '<form method="post"><p>This tool will scan all published posts and append your tracking ID to Microsoft links missing it.</p>';
    wp_nonce_field('mvp_bulk_update', 'mvp_bulk_update_nonce');
    echo '<p class="submit"><input type="submit" class="button-primary" value="' . esc_attr__('Scan & Update Now', 'mvp-link-tracker-and-analytics') . '"></p></form>';
    echo '</div>';
}
