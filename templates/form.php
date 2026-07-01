<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<form method="POST">
    <input type="text" name="nama" placeholder="Masukkan nama">
    <button type="submit">Kirim</button>
</form>

<?php

if (isset($_POST['nama'])) {
    echo "<h3>Halo, " . $_POST['nama'] . " 👋</h3>";
}