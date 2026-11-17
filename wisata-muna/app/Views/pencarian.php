<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rute Terpendek Wisata Muna</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f6f8; }
        header { background: #0f9d94; color: #fff; padding: 24px; text-align: center; }
        .wrap { max-width: 900px; margin: 20px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 16px; margin-bottom: 16px; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        select, button { padding: 8px; font-size: 14px; margin: 4px 0; }
        button { background: #0f9d94; color: #fff; border: 0; border-radius: 4px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        .err { color: #c0392b; }
        #map { height: 480px; border-radius: 8px; }
    </style>
</head>
<body>
<header>
    <h2>Pencarian Rute Terpendek</h2>
    <small>Wisata Kabupaten Muna - Algoritma Dijkstra</small>
</header>

<div class="wrap">
    <div class="card">
        <form method="get" action="<?= site_url('rute') ?>">
            <label>Dari:
                <select name="start">
                    <?php foreach ($nodes as $n): ?>
                        <option value="<?= $n['id'] ?>" <?= $n['id'] == $start ? 'selected' : '' ?>>
                            <?= esc($n['kode_node']) ?> - <?= esc($n['nama_node']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Ke:
                <select name="end">
                    <option value="">-- Pilih Tujuan --</option>
                    <?php foreach ($nodes as $n): ?>
                        <option value="<?= $n['id'] ?>" <?= $n['id'] == $end ? 'selected' : '' ?>>
                            <?= esc($n['kode_node']) ?> - <?= esc($n['nama_node']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit">Cari Rute</button>
        </form>

        <?php if ($pesan): ?>
            <p class="err"><?= esc($pesan) ?></p>
        <?php endif; ?>

        <?php if ($route): ?>
            <h3>Total jarak: <?= $total ?> km</h3>
            <table>
                <tr><th>No</th><th>Node</th><th>Lokasi</th><th>Jarak dari sebelumnya (km)</th></tr>
                <?php foreach ($route as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($r['kode']) ?></td>
                        <td><?= esc($r['nama']) ?></td>
                        <td><?= $r['segmen'] !== null ? $r['segmen'] : '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <div class="card">
        <div id="map"></div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const route    = <?= json_encode($route) ?>;
    const allNodes = <?= json_encode($nodes) ?>;

    const map = L.map('map').setView([-4.95, 122.65], 9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // semua lokasi wisata (abu-abu)
    allNodes.forEach(n => {
        L.circleMarker([parseFloat(n.latitude), parseFloat(n.longitude)], {
            radius: 5, color: '#888', fillOpacity: 0.7
        }).addTo(map).bindPopup(n.kode_node + ' - ' + n.nama_node);
    });

    // rute terpilih
    if (route.length > 0) {
        const pts  = route.map(r => [r.lat, r.lng]);
        const line = L.polyline(pts, { color: 'blue', weight: 4 }).addTo(map);

        route.forEach((r, i) => {
            const warna = i === 0 ? 'green' : (i === route.length - 1 ? 'orange' : 'blue');
            L.circleMarker([r.lat, r.lng], { radius: 8, color: warna, fillColor: warna, fillOpacity: 1 })
                .addTo(map)
                .bindPopup(r.kode + ' - ' + r.nama + (r.segmen ? '<br>' + r.segmen + ' km' : ''));
        });

        map.fitBounds(line.getBounds(), { padding: [30, 30] });
    }
</script>
</body>
</html>