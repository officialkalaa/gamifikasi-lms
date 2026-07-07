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
        'gamifikasi-reset',
        plugin_dir_url(__FILE__) . 'assets/css/reset.css'
    );

    wp_enqueue_style(
        'gamifikasi-style',
        plugin_dir_url(__FILE__) . 'assets/css/style.css'
    );

    wp_enqueue_style(
    'gamifikasi-components',
    plugin_dir_url(__FILE__) . 'assets/css/components.css'
    );

    wp_enqueue_style(
        'gamifikasi-login',
        plugin_dir_url(__FILE__) . 'assets/css/login.css'
    );

    wp_enqueue_style(
        'gamifikasi-landing',
        plugin_dir_url(__FILE__) . 'assets/css/landing.css'
    );

    wp_enqueue_style(
        'gamifikasi-register',
        plugin_dir_url(__FILE__) . 'assets/css/register.css'
    );

    wp_enqueue_style(
        'gamifikasi-forgot',
        plugin_dir_url(__FILE__) . 'assets/css/forgot.css'
    );

    wp_enqueue_style(
        'gamifikasi-dashboard',
        plugin_dir_url(__FILE__) . 'assets/css/dashboard.css'
    );

    wp_enqueue_script(
        'gamifikasi-app',
        plugin_dir_url(__FILE__) . 'assets/js/app.js',
        array(),
        false,
        true
    );

    wp_enqueue_script(
        'gamifikasi-landing',
        plugin_dir_url(__FILE__) . 'assets/js/landing.js',
        array('gamifikasi-app'),
        false,
        true
    );

    wp_enqueue_script(
        'gamifikasi-login',
        plugin_dir_url(__FILE__) . 'assets/js/login.js',
        array('gamifikasi-app'),
        false,
        true
    );

    wp_enqueue_script(
        'gamifikasi-register',
        plugin_dir_url(__FILE__) . 'assets/js/register.js',
        array('gamifikasi-app'),
        false,
        true
    );

    wp_enqueue_script(
        'gamifikasi-forgot',
        plugin_dir_url(__FILE__) . 'assets/js/forgot.js',
        array('gamifikasi-app'),
        false,
        true
    );

    wp_enqueue_script(
        'gamifikasi-dashboard',
        plugin_dir_url(__FILE__) . 'assets/js/dashboard.js',
        array('gamifikasi-app'),
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

    wp_enqueue_script(
    'lottie',
    'https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js',
    array(),
    null,
    true
);

}

add_action('wp_enqueue_scripts', 'gamifikasi_lms_assets');
