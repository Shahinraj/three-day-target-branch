<?php
function tdt_enqueue_assets() {
    wp_enqueue_style(
        'tdt-style',
        plugin_dir_url(__FILE__) . '../css/style.css',
        [],
        filemtime(plugin_dir_path(__FILE__) . '../css/style.css')
    );

    wp_enqueue_script(
        'tdt-script',
        plugin_dir_url(__FILE__) . '../js/script.js',
        ['jquery'],
        filemtime(plugin_dir_path(__FILE__) . '../js/script.js'),
        true
    );

    wp_localize_script('tdt-script', 'tdt_ajax', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

}
