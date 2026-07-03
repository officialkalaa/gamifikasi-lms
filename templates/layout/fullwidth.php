<?php
if (!defined('ABSPATH')) {
    exit;
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
// Konten halaman akan ditampilkan di sini
echo do_shortcode('[gamifikasi_landing]');
?>

<?php wp_footer(); ?>

</body>
</html>