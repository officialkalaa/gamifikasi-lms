<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<h2>Menu LMS</h2>

<ul>
<?php foreach ($menu as $item) : ?>
    <li><?php echo $item; ?></li>
<?php endforeach; ?>
</ul>

<hr>
<p>Fitur Backend Kala</p>