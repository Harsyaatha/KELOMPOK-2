<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="card">
    <h2>Data Node</h2>
    <a class="btn" href="/admin/node/create">+ Tambah Node</a>
    <table>
        <tr><th>Kode</th><th>Nama</th><th>Latitude</th><th>Longitude</th><th>Aksi</th></tr>
        <?php foreach ($nodes as $n): ?>
            <tr>
                <td><?= esc($n['kode_node']) ?></td>
                <td><?= esc($n['nama_node']) ?></td>
                <td><?= esc($n['latitude']) ?></td>
                <td><?= esc($n['longitude']) ?></td>
                <td>
                    <a class="btn gray" href="/admin/node/edit/<?= $n['id'] ?>">Ubah</a>
                    <form class="inline" method="post" action="/admin/node/delete/<?= $n['id'] ?>"
                          onsubmit="return confirm('Hapus node ini beserta semua jaraknya?')">
                        <?= csrf_field() ?>
                        <button class="btn red" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?= $this->endSection() ?>