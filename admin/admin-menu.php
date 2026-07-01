<?php

if (!defined ('ABSPATH')) {
    exit;
}

function gamifikasi_lms_admin_menu() {

    add_menu_page(
        'Gamifikasi LMS',      // Judul halaman
        'Gamifikasi LMS',      // Nama menu
        'manage_options',      // Hak akses
        'gamifikasi-lms',      // Slug
        'gamifikasi_lms_page', // Fungsi yang dipanggil
        'dashicons-welcome-learn-more',
        20
    );

}

add_action('admin_menu', 'gamifikasi_lms_admin_menu');

function gamifikasi_lms_page() {
    echo '<h1>Halo, selamat datang di Plugin Gamifikasi LMS!</h1>';
}