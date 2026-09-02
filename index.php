<?php
require_once __DIR__ . '/config/database.php';

$stmt = $pdo->query("
    SELECT * FROM eventos
    WHERE ativo = 1
      AND (data_evento IS NULL OR data_evento >= CURDATE())
    ORDER BY data_evento ASC, ordem ASC, id ASC;
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>PHD Academy | Educação avançada em estética</title>
<meta name="description" content="Cursos, workshops, imersões e experiências para profissionais da estética.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/footer.css">

<style>
/* INSTAGRAM FINAL - capas estáticas */
.instagram-final{padding:100px 0;background:#050505;position:relative;overflow:hidden}
.instagram-reels-final{display:grid!important;grid-template-columns:repeat(4,minmax(0,1fr))!important;gap:16px!important}
.reel-card-final{
  position:relative;display:block;aspect-ratio:9/16;overflow:hidden;
  border:1px solid #272727;background:#000;
  transition:transform .35s ease,border-color .35s ease,box-shadow .35s ease
}
.reel-card-final:hover{transform:translateY(-7px);border-color:rgba(245,196,0,.35);box-shadow:0 22px 54px rgba(0,0,0,.42)}
.reel-card-final img{
  position:absolute;inset:0;width:100%;height:100%;display:block;
  object-fit:cover;object-position:center center
}
.reel-card-final:after{
  content:"";position:absolute;inset:0;z-index:1;pointer-events:none;
  background:linear-gradient(180deg,rgba(0,0,0,.02),rgba(0,0,0,.02) 72%,rgba(0,0,0,.20))
}
.reel-play-final{
  position:absolute;left:50%;top:50%;z-index:3;transform:translate(-50%,-50%);
  width:58px;height:58px;border-radius:50%;display:grid;place-items:center;
  background:var(--yellow);color:#050505;font-size:17px;font-weight:900;
  box-shadow:0 0 34px rgba(245,196,0,.18)
}
@media(max-width:1000px){.instagram-reels-final{grid-template-columns:repeat(2,minmax(0,1fr))!important}}
@media(max-width:640px){.instagram-reels-final{grid-template-columns:1fr!important}}
</style>

</head>
<body>
<header class="header">
  <div class="container nav">
    <a href="#inicio" class="logo logo-official" aria-label="PHD Academy">
      <img src="assets/images/logo-phd-academy.png" alt="PHD Academy">
    </a>
    <nav class="menu" id="menu">
      <a href="#eventos">Eventos</a>
      <a href="#formatos">Cursos</a>
      <a href="#hands-on">Hands On</a>
      <a href="#academy">Academy</a>
      <a href="#contato">Contato</a>
    </nav>
    <a href="#eventos" class="nav-cta">Ver agenda</a>
    <button class="menu-btn" id="menuBtn">☰</button>
  </div>
</header>

<main id="inicio">
<section class="hero">
  <div class="hero-ring"></div>
  <div class="hero-particles"><span></span><span></span><span></span></div>
  <div class="container">
    <div class="hero-top">
      <div>
        <div class="kicker">PHD Academy</div>
        <h1>ELEVE SUA<br><span>PRÁTICA.</span></h1>
        <p class="hero-copy">Conhecimento, técnica e experiências para profissionais que querem evoluir, se diferenciar e construir resultados de alto nível na estética.</p>
        <a href="#eventos" class="primary-btn">Explorar eventos</a>
      </div>
      <div class="hero-side">
        <strong>Educação que gera resultado</strong>
        <p>Workshops, imersões e treinamentos com foco em prática, segurança clínica, atualização e networking profissional.</p>
      </div>
    </div>

    <div id="eventos" class="phd-events-wrap">
      <div class="events-head">
        <div><div class="kicker">Agenda PHD</div><h2>Workshops e cursos de estética avançada</h2></div>
      </div>

      <?php if(count($eventos)): ?>
      <div class="phd-events-grid">
        <?php foreach($eventos as $evento):
          $dt = new DateTime($evento['data_evento']);
          $slug = $evento['slug'];
          if ($slug === 'tricologia-regenerativa-fios-de-pdo-e-ativos-regenerativos') {
              $saibaMais = 'evento-tricologia-regenerativa.html';
          } elseif ($slug === 'workshop-phd-harmonizacao-glutea-com-pratica-3d') {
              $saibaMais = 'evento-harmonizacao-glutea.html';
          } else {
              $saibaMais = 'evento.php?slug=' . urlencode($slug);
          }
        ?>
        <article class="phd-event-card">
          <div class="phd-event-media" style="background-image:url('uploads/eventos/<?= htmlspecialchars($evento['imagem']) ?>')"></div>
          <div class="phd-event-tag"><?= htmlspecialchars($evento['categoria'] ?: 'Evento') ?></div>
          <div class="phd-event-date"><?= $dt->format('d/m') ?></div>

          <div class="phd-event-body">
            <div class="phd-event-main">
              <div class="phd-event-location"><?= htmlspecialchars($evento['cidade']) ?></div>
              <h3 class="phd-event-title"><?= htmlspecialchars($evento['titulo']) ?></h3>
            </div>

            <div class="phd-event-footer">
              <div class="phd-event-meta">
                <div class="phd-event-row"><span>Data</span><strong><?= $dt->format('d/m/Y') ?></strong></div>
                <div class="phd-event-row"><span>Speaker</span><strong><?= htmlspecialchars($evento['speaker_nome'] ?: 'PHD Academy') ?></strong></div>
                <div class="phd-event-row"><span>Local</span><strong><?= htmlspecialchars($evento['cidade']) ?></strong></div>
              </div>
              <div class="phd-event-actions">
                <a class="more" href="<?= htmlspecialchars($saibaMais) ?>">Saiba mais</a>
                <?php if(!empty($evento['link_compra'])): ?>
                  <a class="buy" href="<?= htmlspecialchars($evento['link_compra']) ?>" target="_blank" rel="noopener">Comprar</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
        <div class="empty-events">Novos eventos serão publicados em breve.</div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="strip reveal">
  <div class="strip-wrap">
    <div class="strip-content">
      <span>Conhecimento</span><span class="dot">•</span><span>Ciência</span><span class="dot">•</span><span>Prática</span><span class="dot">•</span><span>Experiência</span><span class="dot">•</span><span>Networking</span><span class="dot">•</span>
      <span>Conhecimento</span><span class="dot">•</span><span>Ciência</span><span class="dot">•</span><span>Prática</span><span class="dot">•</span><span>Experiência</span><span class="dot">•</span><span>Networking</span><span class="dot">•</span>
    </div>
    <div class="strip-content" aria-hidden="true">
      <span>Conhecimento</span><span class="dot">•</span><span>Ciência</span><span class="dot">•</span><span>Prática</span><span class="dot">•</span><span>Experiência</span><span class="dot">•</span><span>Networking</span><span class="dot">•</span>
      <span>Conhecimento</span><span class="dot">•</span><span>Ciência</span><span class="dot">•</span><span>Prática</span><span class="dot">•</span><span>Experiência</span><span class="dot">•</span><span>Networking</span><span class="dot">•</span>
    </div>
  </div>
  <div class="strip-chevron" aria-hidden="true"></div><div class="motion-arrow" aria-hidden="true"></div>
</section>

<section class="section reveal" id="academy">
  <div class="container split">
    <div class="visual"><div class="visual-label">EDUCAÇÃO • CIÊNCIA • EXPERIÊNCIA</div><div class="visual-number">01</div></div>
    <div>
      <div class="kicker">PHD Academy</div>
      <h2 class="section-title">FORMAÇÃO PARA<br><span>QUEM QUER IR ALÉM.</span></h2>
      <p class="copy">A PHD Academy conecta profissionais da estética por meio de conteúdos, experiências e treinamentos com aplicação prática.</p>
    </div>
  </div>
</section>

<section class="section dark2 reveal">
  <div class="container">
    <div class="kicker">Experiência completa</div>
    <h2 class="section-title">VOCÊ APRENDE.<br><span>PRATICA. EVOLUI.</span></h2>
    <div class="pillars">
      <div class="pillar"><div class="pillar-num">01</div><h3>Conhecimento</h3><p>Conteúdo atualizado para uma prática profissional mais segura e estratégica.</p></div>
      <div class="pillar"><div class="pillar-num">02</div><h3>Hands On</h3><p>Experiências práticas que aproximam técnica, produto e execução clínica.</p></div>
      <div class="pillar"><div class="pillar-num">03</div><h3>Networking</h3><p>Conexões com especialistas e profissionais que movimentam o mercado.</p></div>
      <div class="pillar"><div class="pillar-num">04</div><h3>Certificação</h3><p>Reconhecimento da participação nos treinamentos elegíveis da Academy.</p></div>
    </div>
  </div>
</section>
<section class="section reveal" id="formatos">
  <div class="container">
    <div class="kicker">Formação PHD</div>
    <h2 class="section-title">ESCOLHA COMO<br><span>VOCÊ QUER EVOLUIR.</span></h2>
    <div class="format-grid">
      <article class="format"><div class="format-num">01</div><h3>Workshops</h3><p>Treinamentos intensivos com especialistas e aplicação direcionada.</p><a href="#eventos">Ver workshops →</a></article>
      <article class="format"><div class="format-num">02</div><h3>Imersões</h3><p>Experiências aprofundadas para dominar técnicas, protocolos e estratégias.</p><a href="#eventos">Ver imersões →</a></article>
      <article class="format"><div class="format-num">03</div><h3>Hands On</h3><p>Prática orientada para elevar segurança, domínio técnico e execução clínica.</p><a href="#hands-on">Conhecer →</a></article>
    </div>
  </div>
</section>

<section class="section dark2 reveal" id="hands-on">
  <div class="container split">
    <div>
      <div class="kicker">PHD Academy In Company</div>
      <h2 class="section-title">LEVAMOS O<br><span>CONHECIMENTO ATÉ SUA CLÍNICA.</span></h2>
      <p class="copy">Treinamentos personalizados para capacitar sua equipe dentro do próprio ambiente profissional.</p>
      <br>
      <a href="https://wa.me/5511992536041" target="_blank" rel="noopener" class="primary-btn">Quero levar a PHD Academy</a>
    </div></div>
</section>



<section class="instagram-section instagram-final" id="instagram">
  <div class="container">
    <div class="instagram-head">
      <div>
        <div class="kicker">Conteúdo PHD Academy</div>
        <h2>SIGA A PHD ACADEMY<br><span>NO INSTAGRAM.</span></h2>
      </div>
      <p>Conteúdos, bastidores, eventos e experiências da PHD Academy para profissionais que buscam atualização e evolução na estética avançada.</p>
    </div>

    <div class="instagram-reels instagram-reels-final">
      <a class="reel-card-final" href="https://www.instagram.com/reel/DcTiD_OtBEB/?utm_source=ig_web_copy_link&igsi=MzRlODBiNWFlZA==" target="_blank" rel="noopener">
        <img src="assets/images/instagram-cover-1.png" alt="Capa do Reel 1 da PHD Academy">
        <span class="reel-play-final">▶</span>
      </a>

      <a class="reel-card-final" href="https://www.instagram.com/reel/DZ8RaF7oBEs/?utm_source=ig_web_copy_link&igsi=MzRlODBiNWFlZA==" target="_blank" rel="noopener">
        <img src="assets/images/instagram-cover-2.png" alt="Capa do Reel 2 da PHD Academy">
        <span class="reel-play-final">▶</span>
      </a>

      <a class="reel-card-final" href="https://www.instagram.com/p/DXU_Oxmj5aJ/?utm_source=ig_web_copy_link&igsi=MzRlODBiNWFlZA==" target="_blank" rel="noopener">
        <img src="assets/images/instagram-cover-3.png" alt="Capa da publicação 3 da PHD Academy">
        <span class="reel-play-final">▶</span>
      </a>

      <a class="reel-card-final" href="https://www.instagram.com/reel/DNv_7q05KW1/?utm_source=ig_web_copy_link&igsi=MzRlODBiNWFlZA==" target="_blank" rel="noopener">
        <img src="assets/images/instagram-cover-4.png" alt="Capa do Reel 4 da PHD Academy">
        <span class="reel-play-final">▶</span>
      </a>
    </div>

    <div class="instagram-cta">
      <a href="https://www.instagram.com/phdacademy.oficial/" target="_blank" rel="noopener">
        <span class="instagram-icon-official" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="18" height="18">
            <rect x="3" y="3" width="18" height="18" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/>
            <circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/>
            <circle cx="17.3" cy="6.7" r="1.15" fill="currentColor"/>
          </svg>
        </span>
        SIGA NOSSO INSTAGRAM
      </a>
    </div>
  </div>
</section>


<section class="final reveal" id="contato">
  <div class="container">
    <div class="kicker" style="justify-content:center">PHD Academy</div>
    <h2 class="section-title">ESTEJA ENTRE QUEM LIDERA<br><span>A NOVA ESTÉTICA.</span></h2>
    <div class="cta-row">
      <a href="#eventos" class="primary-btn">Ver próximos eventos</a>
      <a href="https://wa.me/5511992536041" target="_blank" rel="noopener" class="ghost-btn">Falar com a Academy</a>
    </div>
  </div>
</section>
</main>



<?php include __DIR__ . '/includes/footer.php'; ?>

<a class="whatsapp-float" href="https://wa.me/5511992536041?text=Olá%20PHD%20Academy!%20Gostaria%20de%20mais%20informações." target="_blank" rel="noopener" aria-label="Falar com a PHD Academy no WhatsApp">
  <span class="wa-icon">✆</span>
  <span class="wa-label">WhatsApp</span>
</a>

<script src="assets/js/main.js"></script>
</body>
</html>