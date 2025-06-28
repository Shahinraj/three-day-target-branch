<?php
//ইউজারকে র‍্যাঙ্ক কাস্টমাইজেশন করার সুবিধা দেওয়ার জন্য এই পেজ 
function tdt_custom_rank_form() {
    if (!is_user_logged_in()) return '<p>অনুগ্রহ করে লগইন করুন।</p>';

    $user_id = get_current_user_id();
    $ranks = [
        'bad' => get_user_meta($user_id, 'tdt_rank_bad', true) ?: 'BAD',
        'good' => get_user_meta($user_id, 'tdt_rank_good', true) ?: 'GOOD',
        'better' => get_user_meta($user_id, 'tdt_rank_better', true) ?: 'BETTER',
        'best' => get_user_meta($user_id, 'tdt_rank_best', true) ?: 'BEST',
    ];

    ob_start(); ?>
    <form method="post">
        <h3>র‍্যাংকিং কাস্টমাইজ করুন</h3>
        <?php foreach ($ranks as $key => $value): ?>
            <p>
                <label for="tdt_<?php echo $key; ?>"> <?php echo strtoupper($key); ?> নাম: </label>
                <input type="text" name="tdt_<?php echo $key; ?>" value="<?php echo esc_attr($value); ?>">
            </p>
        <?php endforeach; ?>
        <input type="submit" name="tdt_rank_save" value="সংরক্ষণ করুন">
    </form>
    <?php
    if (isset($_POST['tdt_rank_save'])) {
        foreach ($ranks as $key => $v) {
            update_user_meta($user_id, 'tdt_rank_' . $key, sanitize_text_field($_POST['tdt_' . $key]));
        }
        echo '<p>সফলভাবে সংরক্ষণ হয়েছে।</p>';
    }

    return ob_get_clean();
}
add_shortcode('tdt_custom_rank_form', 'tdt_custom_rank_form');

add_action('wp_ajax_get_user_ranks', function() {
    $user_id = get_current_user_id();
    wp_send_json_success([
        'bad' => get_user_meta($user_id, 'tdt_rank_bad', true) ?: 'BAD',
        'good' => get_user_meta($user_id, 'tdt_rank_good', true) ?: 'GOOD',
        'better' => get_user_meta($user_id, 'tdt_rank_better', true) ?: 'BETTER',
        'best' => get_user_meta($user_id, 'tdt_rank_best', true) ?: 'BEST',
    ]);
});
