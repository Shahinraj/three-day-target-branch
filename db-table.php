<?php
register_activation_hook(__FILE__, 'tdt_create_custom_table');
function tdt_create_custom_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'three_day_target';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        user_id bigint(20) unsigned NOT NULL,
        target_date date NOT NULL,
        target_value int(11) NOT NULL,
        PRIMARY KEY (id),
        KEY user_date (user_id, target_date)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
