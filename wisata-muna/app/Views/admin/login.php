<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; display: flex; justify-content: center; padding-top: 80px; }
        .box { background: #fff; padding: 24px; border-radius: 8px; width: 320px; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        input { width: 100%; padding: 8px; margin: 4px 0 12px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #0f9d94; color: #fff; border: 0; border-radius: 4px; cursor: pointer; }
        .err { background: #fdecea; color: #c0392b; padding: 8px; border-radius: 4px; margin-bottom: 12px; }
    </style>
</head>
<body>
<div class="box">
    <h3>Login Admin</h3>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="err"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <form method="post" action="/admin/login">
        <?= csrf_field() ?>
        <label>Username</label>
        <input type="text" name="username" required autofocus>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>