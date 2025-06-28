<?php
/*
Plugin Name: Three Day Target
Description: বাংলা UI, ব্যাজ সিস্টেম, রিপোর্ট পেজ সহ একটি WordPress প্লাগইন
Version: 3.0
Author: আপনার নাম
*/

if (!defined('ABSPATH')) exit;

include_once plugin_dir_path(__FILE__) . 'includes/db-table.php';
include_once plugin_dir_path(__FILE__) . 'includes/enqueue-assets.php';
include_once plugin_dir_path(__FILE__) . 'includes/shortcode-display.php';
include_once plugin_dir_path(__FILE__) . 'includes/ajax-handlers.php';
include_once plugin_dir_path(__FILE__) . 'includes/report-page.php';
//include_once plugin_dir_path(__FILE__) . 'includes/tdt-rank-custom-form.php';


add_action('admin_menu', 'tdt_add_admin_menu');
function tdt_add_admin_menu() {
    add_menu_page(
        '3 Day Target Report',
        'Target Report',
        'manage_options',
        'three_day_target_user_report',
        'tdt_render_report_page',
        'dashicons-chart-line',
        6
    );
}
