<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/auth.php';
exigir_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$evento = [
  'titulo'=>'','slug'=>'','categoria'=>'Workshop','data_evento'=>'','horario'=>'','cidade'=>'','endereco'=>'',
  'formato'=>'Presencial','descricao'=>'','descricao_completa'=>'','imagem'=>'',
  'speaker_nome'=>'','speaker_cargo'=>'','speaker_bio'=>'','programacao'=>'','investimento'=>'',
  'link_compra'=>'','status'=>'Inscrições abertas','destaque'=>0,'ordem'=>0,'ativo'=>1
];
if ($id) {
    $stmt=$pdo->prepare("SELECT * FROM eventos WHERE id=?");
    $stmt->execute([$id]);
    $evento=$stmt->fetch() ?: $evento;
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= $id?'Editar':'Novo' ?> evento | PHD Academy</title><link rel="stylesheet" href="admin.css"></head>
<body><header class="admin-header"><div><strong class="admin-brand"><img src="../assets/images/logo-phd-academy.png" alt="PHD Academy"></strong><span>Painel administrativo</span></div><nav><a href="index.php">← Eventos</a><a href="logout.php">Sair</a></nav></header>
<main class="admin-wrap form-wrap"><div class="admin-title"><div><span>EVENTOS</span><h1><?= $id?'Editar evento':'Novo evento' ?></h1></div></div>
<form class="event-form" method="post" enctype="multipart/form-data" action="evento-salvar.php">
<input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
<input type="hidden" name="id" value="<?= $id ?>">
<input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($evento['imagem']) ?>">

<h2 class="form-section-title">Informações do card</h2>
<div class="grid2">
<div><label>Título</label><input name="titulo" required value="<?= htmlspecialchars($evento['titulo']) ?>"></div>
<div><label>Categoria</label><select name="categoria"><?php foreach(['Workshop','Imersão','Masterclass','Hands On','Experience','In Company'] as $c): ?><option <?= $evento['categoria']===$c?'selected':'' ?>><?= $c ?></option><?php endforeach; ?></select></div>
<div><label>Data do evento</label><input type="date" name="data_evento" value="<?= htmlspecialchars($evento['data_evento']) ?>"></div>
<div><label>Horário</label><input name="horario" placeholder="Ex.: 09h às 18h" value="<?= htmlspecialchars($evento['horario']) ?>"></div>
<div><label>Cidade</label><input name="cidade" value="<?= htmlspecialchars($evento['cidade']) ?>"></div>
<div><label>Formato</label><select name="formato"><?php foreach(['Presencial','Online','Híbrido'] as $f): ?><option <?= $evento['formato']===$f?'selected':'' ?>><?= $f ?></option><?php endforeach; ?></select></div>
</div>
<div><label>Descrição curta</label><textarea name="descricao" rows="3"><?= htmlspecialchars($evento['descricao']) ?></textarea></div>
<div><label>Imagem principal do evento</label><input type="file" name="imagem" accept="image/jpeg,image/png,image/webp"><?php if($evento['imagem']): ?><small>Atual: <?= htmlspecialchars($evento['imagem']) ?></small><?php endif; ?></div>

<h2 class="form-section-title">Página “Saiba mais”</h2>
<div class="grid2">
<div><label>Endereço / local</label><input name="endereco" value="<?= htmlspecialchars($evento['endereco']) ?>"></div>
<div><label>Investimento</label><input name="investimento" placeholder="Ex.: R$ 197,00" value="<?= htmlspecialchars($evento['investimento']) ?>"></div>
</div>
<div><label>Descrição completa / apresentação</label><textarea name="descricao_completa" rows="6"><?= htmlspecialchars($evento['descricao_completa']) ?></textarea></div>

<h2 class="form-section-title">Speaker</h2>
<div class="grid2">
<div><label>Nome do speaker</label><input name="speaker_nome" value="<?= htmlspecialchars($evento['speaker_nome']) ?>"></div>
<div><label>Cargo / especialidade</label><input name="speaker_cargo" value="<?= htmlspecialchars($evento['speaker_cargo']) ?>"></div>
</div>
<div><label>Biografia curta</label><textarea name="speaker_bio" rows="4"><?= htmlspecialchars($evento['speaker_bio']) ?></textarea></div>

<h2 class="form-section-title">Programação</h2>
<div>
<label>Programação</label>
<textarea name="programacao" rows="10" placeholder="Use uma linha por módulo no formato: Título|Descrição"><?= htmlspecialchars($evento['programacao']) ?></textarea>
<small>Exemplo: Fundamentos|Contexto, princípios e critérios essenciais.</small>
</div>

<h2 class="form-section-title">Conversão</h2>
<div class="grid2">
<div><label>Link de compra / checkout</label><input type="url" name="link_compra" value="<?= htmlspecialchars($evento['link_compra']) ?>"></div>
<div><label>Status</label><select name="status"><?php foreach(['Inscrições abertas','Últimas vagas','Esgotado','Em breve'] as $s): ?><option <?= $evento['status']===$s?'selected':'' ?>><?= $s ?></option><?php endforeach; ?></select></div>
<div><label>Ordem</label><input type="number" name="ordem" value="<?= (int)$evento['ordem'] ?>"></div>
<div><label>URL automática</label><input disabled value="<?= $evento['slug'] ? '/evento.php?slug='.htmlspecialchars($evento['slug']) : 'Será criada automaticamente' ?>"></div>
</div>
<div class="checks"><label><input type="checkbox" name="destaque" value="1" <?= $evento['destaque']?'checked':'' ?>> Destacar na Home</label><label><input type="checkbox" name="ativo" value="1" <?= $evento['ativo']?'checked':'' ?>> Evento ativo</label></div>
<div class="form-actions"><a class="btn-secondary" href="index.php">Cancelar</a><button class="btn-primary" type="submit">Salvar evento</button></div>
</form></main></body></html>