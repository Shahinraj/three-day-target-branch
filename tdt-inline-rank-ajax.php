<?php
add_action('wp_ajax_update_rank_label', function() {
    $user_id = get_current_user_id();
    $rank = sanitize_key($_POST['rank']);
    $value = sanitize_text_field($_POST['value']);

    if (in_array($rank, ['bad', 'good', 'better', 'best'])) {
        update_user_meta($user_id, 'tdt_rank_' . $rank, $value);
        wp_send_json_success();
    } else {
        wp_send_json_error('Invalid rank');
    }
});
