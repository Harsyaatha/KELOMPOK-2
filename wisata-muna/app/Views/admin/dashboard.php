<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="card">
    <h2>Dashboard</h2>
    <table>
        <tr><th>Jumlah node (lokasi)</th><td><?= $jmlNode ?></td></tr>
        <tr><th>Jumlah koneksi jarak</th><td><?= $jmlJarak ?></td></tr>
        <tr><th>Jumlah akun admin</th><td><?= $jmlAdmin ?></td></tr>
    </table>
</div>
<?= $this->endSection() ?>