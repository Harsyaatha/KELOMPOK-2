<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Wisata Muna</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f6f8; }
        nav { background: #0f9d94; color: #fff; padding: 12px 24px; display: flex; gap: 16px; align-items: center; }
        nav a { color: #fff; text-decoration: none; }
        nav .spacer { flex: 1; }
        .wrap { max-width: 900px; margin: 20px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 16px; margin-bottom: 16px; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        input, select { padding: 8px; font-size: 14px; width: 100%; box-sizing: border-box; margin: 4px 0 12px; }
        .btn { display: inline-block; padding: 6px 12px; background: #0f9d94; color: #fff; border: 0; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn.red { background: #c0392b; }
        .btn.gray { background: #777; }
        .ok { background: #e6f6ec; color: #1e7d46; padding: 8px 12px; border-radius: 4px; margin-bottom: 12px; }
        .err { background: #fdecea; color: #c0392b; padding: 8px 12px; border-radius: 4px; margin-bottom: 12px; }
        form.inline { display: inline; }
    </style>
</head>
<body>
<nav>
    <strong>Admin Wisata Muna</strong>
    <a href="/admin">Dashboard</a>
    <a href="/admin/node">Node</a>
    <a href="/admin/jarak">Jarak</a>
    <a href="/rute" target="_blank">Lihat Situs</a>
    <span class="spacer"></span>
    <span><?= esc(session('admin_name')) ?></span>
    <a href="/admin/logout">Logout</a>
</nav>
<div class="wrap">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="ok"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="err"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="err">
            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                <div><?= esc($e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>
</body>
</html>