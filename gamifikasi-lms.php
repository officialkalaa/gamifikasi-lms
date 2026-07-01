<?php
/**
 * Plugin Name: Gamifikasi LMS
 * Plugin URI: https://gamifikasilms.local
 * Description: Plugin Mini LMS Gamifikasi.
 * Version: 1.0.1
 * Author: Kala Official
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/loader.php';

function gamifikasi_lms_assets() {

    wp_enqueue_style(
        'gamifikasi-style',
        plugin_dir_url(__FILE__) . 'assets/css/style.css'
    );

    wp_enqueue_script(
        'gamifikasi-script',
        plugin_dir_url(__FILE__) . 'assets/js/script.js',
        array(),
        false,
        true
    );

}

add_action('wp_enqueue_scripts', 'gamifikasi_lms_assets');

