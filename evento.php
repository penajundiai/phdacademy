<?php
require_once __DIR__ . '/config/database.php';

$slug = trim($_GET['slug'] ?? '');
$stmt = $pdo->prepare("SELECT * FROM eventos WHERE slug=? AND ativo=1 LIMIT 1");
$stmt->execute([$slug]);
$e = $stmt->fetch();

if (!$e) {
    http_response_code(404);
    exit('Evento não encontrado.');
}

$programacao = [];
foreach (preg_split('/\r\n|\r|\n/', trim($e['programacao'] ?? '')) as $linha) {
    if (!$linha) continue;
    $partes = array_map('trim', explode('|', $linha, 2));
    $programacao[] = ['titulo'=>$partes[0], 'descricao'=>$partes[1] ?? ''];
}
$dataFormatada = $e['data_evento'] ? date('d/m/Y', strtotime($e['data_evento'])) : 'Em breve';
$compra = !empty($e['link_compra']) ? $e['link_compra'] : '#inscricao';
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($e['titulo']) ?> | PHD Academy</title>
<meta name="description" content="<?= htmlspecialchars($e['descricao']) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/evento.css">
<link rel="stylesheet" href="assets/css/footer.css">
</head>
<body>
<header class="header">
  <div class="container nav">
    <a class="logo logo-official" href="/" aria-label="PHD Academy">
      <img src="assets/images/logo-phd-academy.png" alt="PHD Academy">
    </a>
    <a class="nav-back" href="/">← Voltar aos eventos</a>
    <a class="nav-buy" href="<?= htmlspecialchars($compra) ?>" <?= $e['link_compra']?'target="_blank" rel="noopener"':'' ?>>Garantir minha vaga</a>
  </div>
</header>

<main>
<section class="hero">
  <div class="container hero-grid">
    <div>
      <div class="kicker"><?= htmlspecialchars($e['categoria']) ?> • PHD Academy</div>
      <h1><?= nl2br(htmlspecialchars(strtoupper($e['titulo']))) ?></h1>
      <p class="hero-copy"><?= nl2br(htmlspecialchars($e['descricao_completa'] ?: $e['descricao'])) ?></p>
      <div class="hero-meta">
        <div class="chip">Data: <?= $dataFormatada ?></div>
        <?php if($e['horario']): ?><div class="chip">Horário: <?= htmlspecialchars($e['horario']) ?></div><?php endif; ?>
        <?php if($e['cidade']): ?><div class="chip"><?= htmlspecialchars($e['cidade']) ?></div><?php endif; ?>
        <div class="chip"><?= htmlspecialchars($e['formato']) ?></div>
      </div>
      <div class="cta-row">
        <a class="btn btn-primary" href="<?= htmlspecialchars($compra) ?>" <?= $e['link_compra']?'target="_blank" rel="noopener"':'' ?>>Garantir minha vaga</a>
        <a class="btn btn-ghost" href="#programacao">Ver programação</a>
      </div>
    </div>

    <div class="hero-card" <?php if(($e['imagem_banner'] ?: $e['imagem'])): ?>style="background-image:linear-gradient(180deg,transparent 30%,rgba(0,0,0,.88) 100%),url('uploads/eventos/<?= htmlspecialchars(($e['imagem_banner'] ?: $e['imagem'])) ?>');background-size:cover;background-position:center;"<?php endif; ?>>
      <div class="hero-card-content">
        <div class="tag"><?= htmlspecialchars($e['status']) ?></div>
        <h3>Conhecimento que<br>gera evolução.</h3>
        <p><?= htmlspecialchars($e['formato']) ?> • Experiência • Networking • Certificação</p>
      </div>
    </div>
  </div>
</section>

<section class="strip">Técnica • Prática • Ciência • Experiência • Networking • Certificação</section>

<section class="section">
  <div class="container">
    <div class="kicker">Por que participar</div>
    <h2 class="section-title">UMA EXPERIÊNCIA PENSADA<br><span>PARA SUA EVOLUÇÃO.</span></h2>
    <p class="copy">Mais do que assistir a um conteúdo, você participa de uma jornada de atualização profissional com foco em aplicação prática, tomada de decisão e construção de resultados de alto nível.</p>
    <div class="value-grid">
      <div class="value"><div class="num">01</div><h3>Conteúdo atualizado</h3><p>Conhecimento aplicado à realidade profissional e às demandas atuais do mercado.</p></div>
      <div class="value"><div class="num">02</div><h3>Aplicação prática</h3><p>Abordagem orientada para transformar conceito em segurança e execução.</p></div>
      <div class="value"><div class="num">03</div><h3>Networking</h3><p>Conexão com profissionais e especialistas que compartilham os mesmos objetivos.</p></div>
      <div class="value"><div class="num">04</div><h3>Certificação</h3><p>Certificado de participação nos eventos elegíveis da PHD Academy.</p></div>
    </div>
  </div>
</section>

<section class="section dark2">
  <div class="container">
    <div class="kicker">Para quem é</div>
    <h2 class="section-title">SE VOCÊ BUSCA<br><span>EVOLUIR, ESTE EVENTO É PARA VOCÊ.</span></h2>
    <div class="audience-grid">
      <div class="audience"><h3>Profissionais em evolução</h3><p>Para quem quer ampliar conhecimento, segurança e repertório técnico.</p></div>
      <div class="audience"><h3>Profissionais experientes</h3><p>Para quem busca atualização, novas abordagens e refinamento de estratégia.</p></div>
      <div class="audience"><h3>Clínicas e equipes</h3><p>Para quem quer elevar o padrão de entrega e alinhar conhecimento dentro da equipe.</p></div>
      <div class="audience"><h3>Quem quer se diferenciar</h3><p>Para quem entende que conhecimento e experiência são ativos decisivos na carreira.</p></div>
    </div>
  </div>
</section>

<section class="section" id="programacao">
  <div class="container">
    <div class="kicker">Conteúdo</div>
    <h2 class="section-title">O QUE VOCÊ<br><span>VAI VIVENCIAR.</span></h2>
    <div class="program">
      <?php if($programacao): foreach($programacao as $i=>$p): ?>
      <div class="program-item"><strong>MÓDULO <?= str_pad($i+1,2,'0',STR_PAD_LEFT) ?></strong><div><h3><?= htmlspecialchars($p['titulo']) ?></h3><p><?= htmlspecialchars($p['descricao']) ?></p></div></div>
      <?php endforeach; else: ?>
      <div class="program-item"><strong>PROGRAMAÇÃO</strong><div><h3>Conteúdo em definição</h3><p>A programação completa será divulgada em breve.</p></div></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php if($e['speaker_nome'] || $e['speaker_bio']): ?>
<section class="section dark2">
  <div class="container speaker-wrap">
    <div class="speaker-photo"></div>
    <div>
      <div class="kicker">Speaker</div>
      <h2 class="section-title">APRENDA COM<br><span>QUEM VIVE A PRÁTICA.</span></h2>
      <h3 class="speaker-name"><?= htmlspecialchars($e['speaker_nome'] ?: 'Speaker PHD Academy') ?></h3>
      <div class="speaker-role"><?= htmlspecialchars($e['speaker_cargo']) ?></div>
      <p class="copy"><?= nl2br(htmlspecialchars($e['speaker_bio'])) ?></p>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="offer" id="inscricao">
  <div class="container offer-grid">
    <div>
      <div class="kicker"><?= htmlspecialchars($e['status']) ?></div>
      <h2>GARANTA<br>SUA VAGA.</h2>
      <p>As vagas podem ser limitadas para preservar a qualidade da experiência e o aproveitamento dos participantes.</p>
      <?php if($e['endereco']): ?><p><strong>Local:</strong> <?= htmlspecialchars($e['endereco']) ?></p><?php endif; ?>
    </div>
    <div class="price-card">
      <div class="price-label">Investimento</div>
      <?php if($e['slug'] === 'tricologia-regenerativa-fios-de-pdo-e-ativos-regenerativos'): ?>
        <div class="discount-badge">50% OFF</div>
        <div class="discount-from">De R$ 394,00 por</div>
      <?php endif; ?>
      <div class="price"><?= htmlspecialchars($e['investimento'] ?: 'Consulte') ?></div>
      <div class="price-note">Condições de pagamento definidas no checkout.</div>
      <a class="btn btn-primary" href="<?= htmlspecialchars($compra) ?>" <?= $e['link_compra']?'target="_blank" rel="noopener"':'' ?>>Quero participar</a>
    </div>
  </div>
</section>

<section class="section dark2">
  <div class="container">
    <div class="kicker">Dúvidas frequentes</div>
    <h2 class="section-title">ANTES DE<br><span>GARANTIR SUA VAGA.</span></h2>
    <div class="faq">
      <details><summary>Quem pode participar?</summary><p>O público elegível pode variar de acordo com o tema e a proposta de cada evento.</p></details>
      <details><summary>O evento oferece certificado?</summary><p>Eventos elegíveis podem oferecer certificado de participação.</p></details>
      <details><summary>Como funciona o pagamento?</summary><p>As formas disponíveis aparecem diretamente na plataforma de checkout.</p></details>
      <details><summary>Onde será realizado?</summary><p><?= htmlspecialchars($e['endereco'] ?: 'As orientações de local e acesso serão informadas aos participantes.') ?></p></details>
    </div>
  </div>
</section>

<section class="final">
  <div class="container">
    <div class="kicker" style="justify-content:center">Seu próximo passo</div>
    <h2 class="section-title">CONHECIMENTO MUDA<br><span>A FORMA COMO VOCÊ ENTREGA RESULTADOS.</span></h2>
    <p class="copy">Reserve sua vaga e faça parte da próxima experiência PHD Academy.</p>
    <div class="cta-row"><a class="btn btn-primary" href="<?= htmlspecialchars($compra) ?>" <?= $e['link_compra']?'target="_blank" rel="noopener"':'' ?>>Garantir minha vaga</a></div>
  </div>
</section>
</main>


<?php include __DIR__ . '/includes/footer.php'; ?>

<a class="whatsapp-float" href="https://wa.me/5511992536041?text=Olá%20PHD%20Academy!%20Gostaria%20de%20mais%20informações%20sobre%20este%20evento." target="_blank" rel="noopener" aria-label="WhatsApp PHD Academy"><span class="wa-icon">✆</span><span class="wa-label">WhatsApp</span></a>
<div class="mobile-buy"><a href="<?= htmlspecialchars($compra) ?>" <?= $e['link_compra']?'target="_blank" rel="noopener"':'' ?>>Garantir minha vaga</a></div>
</body>
</html>