<?php

if (!defined('ABSPATH')) {
    exit;
}

function gamifikasi_add_routes() {

    add_rewrite_rule(
        '^login/?$',
        'index.php?gamifikasi_page=login',
        'top'
    );

    add_rewrite_rule(
    '^landing/?$',
    'index.php?gamifikasi_page=landing-page',
    'top'
);

}

add_action('init', 'gamifikasi_add_routes');

function gamifikasi_query_vars($vars) {

    $vars[] = 'gamifikasi_page';

    return $vars;

}

add_filter('query_vars', 'gamifikasi_query_vars');

function gamifikasi_template_loader() {

    $page = get_query_var('gamifikasi_page');

    if (!$page) {
        return;
    }

    $template = plugin_dir_path(__DIR__) . "../templates/{$page}.php";

    if (!file_exists($template)) {
        wp_die('Template tidak ditemukan.');
    }

    $content = '';

    ob_start();
    include $template;
    $content = ob_get_clean();

    include plugin_dir_path(__DIR__) . "../templates/layout/fullwidth.php";

    exit;
}

add_action('template_redirect', 'gamifikasi_template_loader');