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
wp_enqueue_script(
    'firebase-app',
    'https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js',
    array(),
    null,
    true
);

wp_enqueue_script(
    'firebase-auth',
    'https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js',
    array('firebase-app'),
    null,
    true
);

wp_enqueue_script(
    'firebase-firestore',
    'https://www.gstatic.com/firebasejs/8.10.1/firebase-firestore.js',
    array('firebase-app'),
    null,
    true
);

wp_enqueue_script(
    'firebase-config',
    plugin_dir_url(__FILE__) . 'firebase/firebase-config.js',
    array('firebase-firestore'),
    null,
    true
);
}

add_action('wp_enqueue_scripts', 'gamifikasi_lms_assets');

