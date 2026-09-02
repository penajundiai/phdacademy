CREATE TABLE admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(80) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  ativo TINYINT(1) NOT NULL DEFAULT 1,
  criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE eventos (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(180) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  categoria VARCHAR(80) NOT NULL DEFAULT 'Workshop',
  data_evento DATE NULL,
  horario VARCHAR(120) NULL,
  cidade VARCHAR(160) NULL,
  endereco VARCHAR(255) NULL,
  formato VARCHAR(80) NOT NULL DEFAULT 'Presencial',
  descricao TEXT NULL,
  descricao_completa MEDIUMTEXT NULL,
  imagem VARCHAR(255) NULL,
  imagem_banner VARCHAR(255) NULL,
  speaker_nome VARCHAR(180) NULL,
  speaker_cargo VARCHAR(255) NULL,
  speaker_bio TEXT NULL,
  programacao MEDIUMTEXT NULL,
  investimento VARCHAR(80) NULL,
  link_compra VARCHAR(500) NULL,
  status VARCHAR(80) NOT NULL DEFAULT 'Inscrições abertas',
  destaque TINYINT(1) NOT NULL DEFAULT 0,
  ordem INT NOT NULL DEFAULT 0,
  ativo TINYINT(1) NOT NULL DEFAULT 1,
  criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_eventos_data (data_evento),
  INDEX idx_eventos_ativo (ativo),
  INDEX idx_eventos_destaque (destaque)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO eventos (
  titulo,slug,categoria,data_evento,horario,cidade,endereco,formato,descricao,descricao_completa,
  imagem,imagem_banner,speaker_nome,speaker_cargo,speaker_bio,programacao,investimento,link_compra,status,destaque,ordem,ativo
) VALUES
(
  'Tricologia Regenerativa: Fios de PDO e Ativos Regenerativos',
  'tricologia-regenerativa-fios-de-pdo-e-ativos-regenerativos',
  'Workshop',
  '2026-09-17',
  '10h às 17h',
  'São Paulo — SP',
  'Sede da PHD - Morumbi, Av. das Nações Unidas, 14401 - Torre Paineira / B2 - 17º andar - São Paulo, SP',
  'Presencial',
  'Da prática comum à atuação de alto valor com a imersão Tricologia Regenerativa: Fios de PDO e Ativos Regenerativos.',
  'Em um mercado onde muitos profissionais oferecem os mesmos tratamentos, quem se destaca não é quem possui mais tecnologias, mas quem sabe utilizá-las com estratégia.

No workshop Tricologia Regenerativa: da Biologia à Decisão Clínica, você aprenderá como integrar os fios de PDO e outras tecnologias regenerativas a um raciocínio clínico capaz de diferenciar sua prática e elevar o valor dos seus atendimentos.

Mais do que novas técnicas, você desenvolverá uma forma de pensar que transforma ciência em decisões clínicas.

Experiência exclusiva: este workshop acontece dois dias antes da apresentação da Dra. Diva Almeida no CIT - Congresso Internacional de Tricologia, oferecendo aos participantes acesso antecipado aos conceitos e discussões que estarão presentes em um dos principais encontros científicos da área.

PRESENTE ESPECIAL: o valor integral do ingresso será disponibilizado como bônus de desconto na PHD. Invista na sua educação e, caso deseje abastecer sua clínica, tenha 100% do valor revertido como incentivo na compra dos nossos produtos.',
  'tricologia-card-9x16.png',
  'Dra. Diva Almeida',
  'Especialista Capilar',
  'Dra. Diva Almeida é fundadora da HCF®, fisioterapeuta dermato funcional e especialista em Tricologia e Terapia Capilar Avançada. Sua abordagem integra ciência, tecnologias regenerativas e raciocínio clínico para formar profissionais que desejam construir uma atuação diferenciada e de alto valor.',
  'Aplicação clínica dos fios de PDO na Tricologia Regenerativa|Princípios e aplicação dos fios de PDO dentro de uma estratégia regenerativa capilar.
Integração de tecnologias regenerativas|Como integrar PDO, PDRN, biomateriais e suporte sistêmico em protocolos modernos.
Raciocínio clínico estratégico|Como tomar decisões terapêuticas mais estratégicas a partir da biologia e da avaliação clínica.
Casos clínicos e planejamento terapêutico|Discussão de casos e planejamento baseado na biologia do folículo.',
  'R$ 197,00',
  'https://www.sympla.com.br/evento/tricologia-regenerativa-fios-de-pdo-e-ativos-regenerativos/3521442',
  'Inscrições abertas',
  1,
  0,
  1
);

INSERT INTO eventos (
  titulo,slug,categoria,data_evento,horario,cidade,endereco,formato,descricao,descricao_completa,
  imagem,imagem_banner,speaker_nome,speaker_cargo,speaker_bio,programacao,investimento,link_compra,status,destaque,ordem,ativo
) VALUES
(
  'Workshop PHD - Harmonização Glútea com Prática 3D',
  'workshop-phd-harmonizacao-glutea-com-pratica-3d',
  'Workshop',
  '2026-09-26',
  '10h às 16h',
  'São Paulo — SP',
  'Av. das Nações Unidas, 14401, Torre Paineira (B2) - 17º andar - PHD, São Paulo, SP',
  'Presencial',
  'Técnicas de harmonização glútea, tendências do mercado e prática em silicone 3D com a Speaker PHD Dra. Silvana Ferreira.',
  'CONVITE ESPECIAL - HARMONIZAÇÃO GLÚTEA COM PRÁTICA 3D

O Workshop com a Speaker PHD, Dra. Silvana Ferreira, apresentará técnicas eficientes da harmonização glútea, contemplando as tendências do mercado de Estética e cuidados que te diferenciam na área.

Você também poderá aplicar, em uma dinâmica com silicone 3D, o conhecimento adquirido ao longo do evento e compreender na prática todo o processo de construção de um novo glúteo.

As vagas são limitadas.',
  'harmonizacao-glutea-card-9x16.png',
  'harmonizacao-glutea-banner-16x9.png',
  'Dra. Silvana Ferreira',
  'Speaker PHD',
  '',
  'Harmonização glútea|Técnicas eficientes, tendências do mercado e cuidados aplicados à estética.
Prática 3D|Dinâmica em silicone 3D para aplicar o conhecimento adquirido e compreender na prática o processo de construção de um novo glúteo.',
  '',
  'https://www.sympla.com.br/evento/workshop-phd-harmonizacao-glutea-com-pratica-3d/3540197',
  'Inscrições abertas',
  1,
  1,
  1
);
