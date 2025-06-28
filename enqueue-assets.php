<?php
function tdt_enqueue_assets() {
    // ✅ CSS ফাইল enqueue
    wp_enqueue_style(
        'tdt-style',
        plugin_dir_url(__FILE__) . '../css/style.css',
        [],
        filemtime(plugin_dir_path(__FILE__) . '../css/style.css')
    );

    // ✅ Main JS ফাইল (যেমন: র‍্যাংকিং আপডেট, টাইম ইত্যাদি)
    wp_enqueue_script(
        'tdt-script',
        plugin_dir_url(__FILE__) . '../js/script.js',
        ['jquery'],
        filemtime(plugin_dir_path(__FILE__) . '../js/script.js'),
        true
    );

    // ✅ Inline Rank Edit JS ফাইল (যেখানে BAD, GOOD ক্লিক করে পরিবর্তন হয়)
    wp_enqueue_script(
        'tdt-inline-edit',
        plugin_dir_url(__FILE__) . '../js/tdt-inline-edit.js',
        ['jquery'],
        filemtime(plugin_dir_path(__FILE__) . '../js/tdt-inline-edit.js'),
        true
    );

    // ✅ Ajax URL — শুধুমাত্র একবার localize করুন (সব স্ক্রিপ্টে এটি ব্যবহার করতে পারবে)
    wp_localize_script('tdt-inline-edit', 'tdt_ajax', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

	wp_enqueue_script(
    'tdt-rank-color',
    plugins_url('../js/tdt-rank-color-handler.js', __FILE__),
    ['jquery'],
    null,
    true
);

}
add_action('wp_enqueue_scripts', 'tdt_enqueue_assets');
