<?php
add_action('wp_ajax_tdt_add_point', 'tdt_add_point');
function tdt_add_point() {
    global $wpdb;
    $user_id = get_current_user_id();
    $today = date('Y-m-d');
    $table = $wpdb->prefix . 'three_day_target';

    $existing = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table WHERE user_id=%d AND target_date=%s", $user_id, $today));
    if ($existing) {
        $wpdb->query($wpdb->prepare("UPDATE $table SET target_value = target_value + 1 WHERE id=%d", $existing));
    } else {
        $wpdb->insert($table, ['user_id' => $user_id, 'target_date' => $today, 'target_value' => 1]);
    }

    $score = $wpdb->get_var($wpdb->prepare("SELECT target_value FROM $table WHERE user_id=%d AND target_date=%s", $user_id, $today));
    $best_days = 0;
    for ($i = 0; $i < 3; $i++) {
        $day = date('Y-m-d', strtotime("-$i days"));
        $day_score = $wpdb->get_var($wpdb->prepare("SELECT target_value FROM $table WHERE user_id=%d AND target_date=%s", $user_id, $day));
        if ($day_score >= 15) $best_days++;
    }

    wp_send_json_success(['score' => $score, 'best_days' => $best_days]);
}

add_action('wp_ajax_tdt_reset_score', 'tdt_reset_score');
function tdt_reset_score() {
    global $wpdb;
    $user_id = get_current_user_id();
    $today = date('Y-m-d');
    $table = $wpdb->prefix . 'three_day_target';
    $wpdb->delete($table, ['user_id' => $user_id, 'target_date' => $today]);
    wp_send_json_success();
}
