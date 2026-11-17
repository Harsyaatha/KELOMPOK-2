<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php
    $asal   = old('id_node_asal', $row['id_node_asal'] ?? '');
    $tujuan = old('id_node_tujuan', $row['id_node_tujuan'] ?? '');
?>
<div class="card">
    <h2><?= esc($judul) ?></h2>
    <form method="post" action="<?= esc($action) ?>">
        <?= csrf_field() ?>
        <label>Node awal</label>
        <select name="id_node_asal" required>
            <option value="">-- Pilih --</option>
            <?php foreach ($nodes as $n): ?>
                <option value="<?= $n['id'] ?>" <?= $n['id'] == $asal ? 'selected' : '' ?>>
                    <?= esc($n['kode_node']) ?> - <?= esc($n['nama_node']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Node tujuan</label>
        <select name="id_node_tujuan" required>
            <option value="">-- Pilih --</option>
            <?php foreach ($nodes as $n): ?>
                <option value="<?= $n['id'] ?>" <?= $n['id'] == $tujuan ? 'selected' : '' ?>>
                    <?= esc($n['kode_node']) ?> - <?= esc($n['nama_node']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Jarak (km)</label>
        <input type="text" name="jarak" value="<?= esc(old('jarak', $row['jarak'] ?? '')) ?>" required>

        <button class="btn" type="submit">Simpan</button>
        <a class="btn gray" href="/admin/jarak">Batal</a>
    </form>
</div>
<?= $this->endSection() ?>