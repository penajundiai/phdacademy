<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/auth.php';
exigir_login();

$stmt = $pdo->query("SELECT * FROM eventos ORDER BY data_evento ASC, id DESC");
$eventos = $stmt->fetchAll();
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Painel | PHD Academy</title><link rel="stylesheet" href="admin.css"></head>
<body><header class="admin-header"><div><strong class="admin-brand"><img src="../assets/images/logo-phd-academy.png" alt="PHD Academy"></strong><span>Painel administrativo</span></div><nav><a href="../" target="_blank">Ver site</a><a href="logout.php">Sair</a></nav></header>
<main class="admin-wrap">
<div class="admin-title"><div><span>EVENTOS</span><h1>Gerenciar eventos</h1></div><a class="btn-primary" href="evento-form.php">+ Novo evento</a></div>
<div class="table-wrap"><table><thead><tr><th>Evento</th><th>Data</th><th>Cidade</th><th>Status</th><th>Destaque</th><th>Ações</th></tr></thead><tbody>
<?php foreach($eventos as $e): ?><tr>
<td><strong><?= htmlspecialchars($e['titulo']) ?></strong><small><?= htmlspecialchars($e['categoria']) ?></small></td>
<td><?= $e['data_evento'] ? date('d/m/Y',strtotime($e['data_evento'])) : '—' ?></td>
<td><?= htmlspecialchars($e['cidade']) ?></td>
<td><span class="status <?= $e['ativo']?'on':'off' ?>"><?= $e['ativo']?'Ativo':'Inativo' ?></span></td>
<td><?= $e['destaque']?'Sim':'Não' ?></td>
<td class="actions"><a href="evento-form.php?id=<?= $e['id'] ?>">Editar</a><a href="evento-duplicar.php?id=<?= $e['id'] ?>">Duplicar</a><a class="danger" href="evento-excluir.php?id=<?= $e['id'] ?>" onclick="return confirm('Excluir este evento?')">Excluir</a></td>
</tr><?php endforeach; ?>
</tbody></table></div>
</main></body></html>