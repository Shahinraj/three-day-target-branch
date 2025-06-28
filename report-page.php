<?php
function tdt_render_report_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    echo '<div class="wrap">';
    echo '<h1>3 Day Target User Report</h1>';
    echo '<p>এখানে রিপোর্ট যুক্ত হবে।</p>';
    echo '</div>';
}
