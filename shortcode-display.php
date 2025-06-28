<?php
function tdt_display_tracker() {
    if (!is_user_logged_in()) return '<p>অনুগ্রহ করে লগইন করুন।</p>';
    if (function_exists('tdt_enqueue_assets')) tdt_enqueue_assets();

    global $wpdb;
    $user_id = get_current_user_id();
    $timestamp = current_time('timestamp');
    $today = date('Y-m-d', $timestamp);
    $table = $wpdb->prefix . 'three_day_target';

    $score_today = $wpdb->get_var($wpdb->prepare(
        "SELECT target_value FROM $table WHERE user_id=%d AND target_date=%s",
        $user_id,
        $today
    )) ?: 0;

    $best_days = 0;
    for ($i = 0; $i < 3; $i++) {
        $day = date('Y-m-d', strtotime("-$i days", $timestamp));
        $score = $wpdb->get_var($wpdb->prepare(
            "SELECT target_value FROM $table WHERE user_id=%d AND target_date=%s",
            $user_id,
            $day
        ));
        if ($score >= 15) $best_days++;
    }

    // র‍্যাংক টেক্সটগুলো ইউজার কাস্টমাইজ করলে সেটি নেবে, না হলে ডিফল্ট
    $ranks = [
        'bad' => get_user_meta($user_id, 'tdt_rank_bad', true) ?: 'BAD',
        'good' => get_user_meta($user_id, 'tdt_rank_good', true) ?: 'GOOD',
        'better' => get_user_meta($user_id, 'tdt_rank_better', true) ?: 'BETTER',
        'best' => get_user_meta($user_id, 'tdt_rank_best', true) ?: 'BEST',
    ];

    ob_start(); ?>
    <div id="tdt-container" data-score="<?= esc_attr($score_today); ?>" data-best-days="<?= esc_attr($best_days); ?>">
        <h3 class="tdt-header">3 Day Target</h3>

        <div class="tdt-inline-info">
            <span id="today-date">আজকের তারিখ: <?php echo date_i18n('d M Y', $timestamp); ?> </span>
            <span id="current-time"></span>
        </div>

        <div id="today-point"></div>

        <div class="badge-container">
            <div class="badge">★</div>
        </div>

        <div id="ranks">
            <button id="BEST" class="editable-rank"><?php echo esc_html($ranks['best']); ?></button>
            <button id="BETTER" class="editable-rank"><?php echo esc_html($ranks['better']); ?></button>
            <button id="GOOD" class="editable-rank"><?php echo esc_html($ranks['good']); ?></button>
            <button id="BAD" class="editable-rank"><?php echo esc_html($ranks['bad']); ?></button>
        </div>

        <div id="congratsMessage"></div>

        <div class="tdt-buttons">
            <button id="yesBtn">Yes</button>
            <button id="resetBtn">Reset</button>
        </div>

        <p>আপনার জন্য বরাদ্দকৃত ১টি কাজ সম্পন্ন হলে Yes ক্লিক করুন।</p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('three_day_target', 'tdt_display_tracker');
