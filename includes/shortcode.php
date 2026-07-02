<?php

if (!defined('ABSPATH')) {
    exit;
}

function gamifikasi_lms_shortcode() {

    $menu = [
        "Dashboard",
        "Quiz",
        "Leaderboard",
        "Profile"
    ];

    ob_start();

    include plugin_dir_path(__DIR__) . 'templates/dashboard.php';

    return ob_get_clean();
}

add_shortcode('gamifikasi_lms', 'gamifikasi_lms_shortcode');

function gamifikasi_landing_shortcode() {

    ob_start();

    include plugin_dir_path(__DIR__) . 'templates/landing-page.php';

    return ob_get_clean();
}

add_shortcode('gamifikasi_landing', 'gamifikasi_landing_shortcode');