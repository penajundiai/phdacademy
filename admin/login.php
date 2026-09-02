<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/auth.php';

if (admin_logado()) {
    header('Location: index.php');
    exit;
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE usuario = ? AND ativo = 1 LIMIT 1");
    $stmt->execute([$usuario]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($senha, $admin['senha_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_usuario'] = $admin['usuario'];
        header('Location: index.php');
        exit;
    }
    $erro = 'Usuário ou senha inválidos.';
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login | PHD Academy</title><link rel="stylesheet" href="admin.css"></head>
<body class="login-body"><div class="login-card"><div class="admin-logo"><img src="../assets/images/logo-phd-academy.png" alt="PHD Academy"></div><h1>Acesso administrativo</h1><p>Entre para gerenciar os eventos do site.</p>
<?php if($erro): ?><div class="alert error"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
<form method="post"><label>Usuário</label><input name="usuario" required autocomplete="username"><label>Senha</label><input type="password" name="senha" required autocomplete="current-password"><button type="submit">Entrar</button></form></div></body></html>