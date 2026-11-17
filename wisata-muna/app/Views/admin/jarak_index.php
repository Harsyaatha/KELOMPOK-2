<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="card">
    <h2>Data Jarak Antar Node</h2>
    <a class="btn" href="/admin/jarak/create">+ Tambah Jarak</a>
    <table>
        <tr><th>No</th><th>Node Awal</th><th>Node Tujuan</th><th>Jarak (km)</th><th>Aksi</th></tr>
        <?php foreach ($rows as $i => $r): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($r['kode_asal']) ?> - <?= esc($r['nama_asal']) ?></td>
                <td><?= esc($r['kode_tujuan']) ?> - <?= esc($r['nama_tujuan']) ?></td>
                <td><?= esc($r['jarak']) ?></td>
                <td>
                    <a class="btn gray" href="/admin/jarak/edit/<?= $r['id'] ?>">Ubah</a>
                    <form class="inline" method="post" action="/admin/jarak/delete/<?= $r['id'] ?>"
                          onsubmit="return confirm('Hapus jarak ini?')">
                        <?= csrf_field() ?>
                        <button class="btn red" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?= $this->endSection() ?>