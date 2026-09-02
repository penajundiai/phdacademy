<?php
require_once __DIR__ . '/config/database.php';

$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strlen($usuario) < 4 || strlen($senha) < 8) {
        $mensagem = 'Use um usuário com pelo menos 4 caracteres e uma senha com pelo menos 8.';
    } else {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        try {
            $pdo->prepare("INSERT INTO admins (usuario, senha_hash, ativo, criado_em) VALUES (?, ?, 1, NOW())")
                ->execute([$usuario, $hash]);
            $mensagem = 'Administrador criado. Exclua o arquivo setup-admin.php do servidor e acesse /admin.';
        } catch (PDOException $e) {
            $mensagem = 'Não foi possível criar o administrador. Talvez o usuário já exista.';
        }
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Configurar administrador</title><style>body{font-family:Arial;background:#080808;color:#fff;display:grid;place-items:center;min-height:100vh}.box{width:400px;max-width:90%;background:#111;padding:25px;border:1px solid #333}input,button{width:100%;padding:12px;margin:7px 0;box-sizing:border-box}button{background:#f5c400;border:0;font-weight:700}.msg{margin:10px 0;color:#f5c400}</style></head><body><div class="box"><h1>Criar administrador</h1><p>Use este arquivo apenas uma vez.</p><?php if($mensagem):?><div class="msg"><?=htmlspecialchars($mensagem)?></div><?php endif;?><form method="post"><input name="usuario" placeholder="Usuário" required><input type="password" name="senha" placeholder="Senha" required><button>Criar administrador</button></form></div></body></html>