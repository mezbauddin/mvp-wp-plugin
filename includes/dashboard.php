<?php
function mvp_render_dashboard() {
    echo '<div class="wrap"><h1>' . esc_html__('📊 MVP Dashboard', 'mvp-link-tracker-and-analytics') . '</h1>';
echo '<p>' . esc_html__('This plugin tracks Microsoft link clicks without collecting personal data like IP address or user agent.', 'mvp-link-tracker-and-analytics') . '</p>';
echo '<p><strong>' . esc_html__('All data is stored locally', 'mvp-link-tracker-and-analytics') . '</strong>. ' . esc_html__('You are responsible for GDPR compliance.', 'mvp-link-tracker-and-analytics') . '</p>';
global $wpdb;
$table = $wpdb->prefix . 'mvp_clicks';
// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- Table name cannot be a placeholder, safe usage. Linter false positive.
// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
$sql = "SELECT DATE(clicked_at) as day, COUNT(*) as clicks FROM $table GROUP BY day ORDER BY day DESC LIMIT 30";
// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
$rows = $wpdb->get_results($sql);
$labels = [];
$data = [];
foreach (array_reverse($rows) as $row) {
    $labels[] = $row->day;
    $data[] = (int)$row->clicks;
}
wp_enqueue_script('mvp-chartjs', plugins_url('../assets/chart.min.js', __FILE__), [], '4.4.1', true);
wp_add_inline_script('mvp-chartjs', 'window.mvpChartData = ' . json_encode(['labels' => $labels, 'data' => $data]) . ';', 'before');
echo '<canvas id="mvpClicksChart" width="600" height="300"></canvas>';
echo '<script>document.addEventListener("DOMContentLoaded",function(){if(window.Chart&&window.mvpChartData){const ctx=document.getElementById("mvpClicksChart").getContext("2d");new Chart(ctx,{type:"bar",data:{labels:window.mvpChartData.labels,datasets:[{label:"Clicks per Day",data:window.mvpChartData.data,backgroundColor:"#0078d4"}]},options:{scales:{y:{beginAtZero:true}}}});}});</script>';
echo '</div>';
