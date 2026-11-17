<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="card">
    <h2><?= esc($judul) ?></h2>
    <form method="post" action="<?= esc($action) ?>">
        <?= csrf_field() ?>
        <label>Kode node (mis. A, B, X)</label>
        <input type="text" name="kode_node" value="<?= esc(old('kode_node', $node['kode_node'] ?? '')) ?>" required>

        <label>Nama lokasi</label>
        <input type="text" name="nama_node" value="<?= esc(old('nama_node', $node['nama_node'] ?? '')) ?>" required>

        <label>Latitude</label>
        <input type="text" name="latitude" value="<?= esc(old('latitude', $node['latitude'] ?? '')) ?>" required>

        <label>Longitude</label>
        <input type="text" name="longitude" value="<?= esc(old('longitude', $node['longitude'] ?? '')) ?>" required>

        <button class="btn" type="submit">Simpan</button>
        <a class="btn gray" href="/admin/node">Batal</a>
    </form>
</div>
<?= $this->endSection() ?>